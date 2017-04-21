<?php

namespace App\Http\Controllers\Web;

use App\Models\Location;
use App\Models\Religion;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\Request;
use App\Services\Web\UserService;

class RegisterController extends BaseController
{
    public function create()
    {
        $this->viewData['step'] = 1;
        return view('web.users.register.step_1', $this->viewData);
    }

    public function createStep2(Request $request)
    {
        $data = $request->only([
            'socialId',
            'provider',
            'email',
            'name',
        ]);

        $this->viewData['step'] = 2;
        $this->viewData['religions'] = Religion::all();
        $this->viewData['locations'] = Location::all($this->currentLocaleId);
        $this->viewData['socialId'] = $data['socialId'];
        $this->viewData['provider'] = $data['provider'];
        $this->viewData['email'] = $data['email'];
        $this->viewData['name'] = $data['name'];

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
            return redirect('/');
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
        $this->viewData['step'] = 3;

        return view('web.users.register.step_3', $this->viewData);
    }

    public function storeViaFaceBook()
    {
        return Socialite::driver('facebook')
            ->redirect();
    }

    public function storeViaFaceBookCallBack()
    {
        try {
            $validate = UserService::validateSocialUser(Socialite::driver('facebook')->user());

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
                ]
            );
        } catch (\Exception $e) {
            return redirect()->action('Web\RegisterController@create');
        }
    }
}
