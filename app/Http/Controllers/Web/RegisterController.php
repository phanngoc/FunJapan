<?php

namespace App\Http\Controllers\Web;

use App\Models\Location;
use App\Models\Religion;
use App\Models\JmbCity;
use App\Models\JmbCountry;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\Request;
use App\Services\Web\UserService;
use App\Services\Admin\LocaleService;
use App\Services\Web\JmbService;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        config(['services.facebook.redirect' => route('facebook_callback')]);
    }

    public function create(Request $request)
    {
        $this->viewData['step'] = 1;
        $this->viewData['referralId'] = $request->get('referralId');

        return view('web.users.register.step_1', $this->viewData);
    }

    public function createStep2(Request $request)
    {
        $data = $request->only([
            'socialId',
            'provider',
            'email',
            'name',
            'referralId',
        ]);

        $this->viewData['step'] = 2;
        $this->viewData['religions'] = Religion::all();
        $this->viewData['locations'] = Location::all($this->currentLocaleId);
        $this->viewData['socialId'] = $data['socialId'];
        $this->viewData['provider'] = $data['provider'];
        $this->viewData['email'] = $data['email'];
        $this->viewData['name'] = $data['name'];
        $this->viewData['referralId'] = $data['referralId'];

        return view('web.users.register.step_2', $this->viewData);
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'birthday_year',
            'birthday_month',
            'birthday_day',
            'name',
            'email',
            'social_id',
            'provider',
            'gender',
            'password',
            'password_confirmation',
            'location_id',
            'religion_id',
            'subscription_new_letter',
            'subscription_reply_noti',
            'accept_policy',
            'referralId',
        ]);
        $data['birthday'] = $data['birthday_year'] . '-' . $data['birthday_month'] . '-' . $data['birthday_day'];
        $data['locale_id'] = $this->currentLocaleId;
        $data['registered_by'] = $data['provider'] ? : 0;
        $data['subscription_new_letter'] = $data['subscription_new_letter'] ? 1 : 0;
        $data['subscription_reply_noti'] = $data['subscription_reply_noti'] ? 1 : 0;

        $validate = UserService::validate($data);
        if (count($validate)) {
            return redirect()->back()->withErrors($validate)->withInput($data);
        }

        $authUser = UserService::create($data);
        if ($authUser) {
            auth()->loginUsingId($authUser->id);

            return redirect()->action('Web\RegisterController@createSuccess');
        }

        return redirect()->back()->withErrors(['updated_fail' => trans('web/user.updated_fail')])->withInput($data);
    }

    public function createStep2ConfirmPass($userId, $socialId, $provider = 1)
    {
        $this->viewData['user'] = UserService::find($userId);
        if (!$this->viewData['user']) {
            return redirect('/' . $this->currentLocale . '/');
        }
        $this->viewData['step'] = 2;
        $this->viewData['socialId'] = $socialId;
        $this->viewData['provider'] = $provider;

        return view('web.users.register.step_2_confirm_pass', $this->viewData);
    }

    public function confirmPass(Request $request)
    {
        $input = $request->only([
            'social_id',
            'provider',
            'email',
            'password',
        ]);

        $validate = UserService::confirmPassValidate($input);

        if (count($validate)) {
            return redirect()->back()->withErrors($validate)->withInput($input);
        }

        if (!auth()->attempt(array_only($input, ['email', 'password']))) {
            return redirect()
                ->back()
                ->withErrors(['password' => trans('web/user.password_wrong')])
                ->withInput($input);
        }

        if (!UserService::updateSocial(auth()->id(), $input)) {
            return redirect()
                ->back()
                ->withErrors(['updated_fail' => trans('web/user.password_wrong')])
                ->withInput($input);
        }

        return redirect()->action('Web\RegisterController@createSuccess');
    }

    public function createSuccess()
    {
        $jmbUser = JmbService::findByUserId(Auth::id());
        if (count($jmbUser) > 0) {
            return redirect()->action('Web\RegisterController@finalStep');
        }
        $user = Auth::user();
        $this->viewData['step'] = 2;
        $this->viewData['currentLocale'] = $this->currentLocale;
        $allJmbCountries = JmbCountry::where('available', 1);
        $allJmbCountriesCode = $allJmbCountries->pluck('code', 'id');
        $allJmbCities = JmbCity::all()->groupBy('jmb_country_id');
        foreach ($allJmbCountriesCode as $key => $cityCode) {
            $this->viewData['allCities'][$cityCode] = $allJmbCities[$key]->pluck('name', 'id');
        }
        $this->viewData['initCity'] = $this->viewData['allCities'][$this->currentLocale]->prepend('---', '');
        $this->viewData['locales'] = $allJmbCountries->pluck('name', 'code')->prepend('---', '');
        $this->viewData['userBirthDay'] = $user->birthday_parse->year;

        return view('web.users.register.jmb_1', $this->viewData);
    }

    public function storeJmb(Request $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = Auth::id();

        if (JmbService::create($inputs)) {
            return redirect()->action('Web\RegisterController@finalStep');
        }
    }

    public function finalStep()
    {
        $jmbUser = JmbService::findByUserId(Auth::id());
        if (count($jmbUser) > 0) {
            $this->viewData['step'] = 3;
            $this->viewData['currentLocale'] = $this->currentLocale;

            return view('web.users.register.jmb_2', $this->viewData);
        }

        return redirect()->action('Web\RegisterController@createSuccess');
    }

    public function storeViaFaceBook(Request $request)
    {
        return Socialite::driver('facebook')
            ->with(['state' => $request->get('referralId')])
            ->redirect();
    }

    public function storeViaFaceBookCallBack(Request $request)
    {
        try {
            $validate = UserService::validateSocialUser(Socialite::driver('facebook')->stateless()->user());

            if ($validate['success']) {
                auth()->login($validate['data']);
                return redirect()->intended();
            }

            if (isset($validate['user_id'])) {
                return redirect()->action(
                    'Web\RegisterController@createStep2ConfirmPass',
                    [
                        'userId' => $validate['user_id'],
                        'socialId' => $validate['social_id'],
                        'provider' => config('user.social_provider.facebook'),
                    ]
                );
            }

            return redirect()->action(
                'Web\RegisterController@createStep2',
                [
                    'socialId' => $validate['social_id'],
                    'email' => $validate['email'],
                    'name' => $validate['name'],
                    'provider' => config('user.social_provider.facebook'),
                    'referralId' => $request->get('state'),
                ]
            );
        } catch (\Exception $e) {
            return redirect()->action('Web\RegisterController@create');
        }
    }
}
