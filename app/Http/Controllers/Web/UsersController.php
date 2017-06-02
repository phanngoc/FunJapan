<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\Admin\LocaleService;
use App\Services\Admin\ArticleService;
use App\Services\Admin\BannerSettingService;
use App\Services\Web\UserService;
use App\Models\Religion;
use App\Models\Location;
use App\Models\Category;
use App\Models\InterestUser;
use Auth;
use Hash;
use App\Http\Requests\Web\UpdateProfileRequest;
use App\Http\Requests\Web\UpdatePasswordRequest;
use App\Services\Web\CategoryService;
use App\Services\Web\TagService;
use Illuminate\Support\Facades\View;
use App\Http\Requests\Web\CloseAccountRequest;
use Session;
use App\Services\Web\PopularSeriesService;

class UsersController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->viewData['popularSeries'] = PopularSeriesService::getPopularSeries($this->currentLocaleId);

        $this->viewData['user'] = Auth::user();
        $this->viewData['religions'] = Religion::all();
        $this->viewData['locations'] = Location::all($this->currentLocaleId);

        return view('web.users.profile', $this->viewData);
    }

    public function update(UpdateProfileRequest $request)
    {
        $data = $request->all();

        if (UserService::update(Auth::id(), $data)) {
            return redirect()->route('profile')->with('status', trans('web/user.profile_page.update_complete'));
        }

        return redirect()->back()->withErrors(['updated_fail' => trans('web/user.updated_fail')])->withInput($data);
    }

    public function interest()
    {
        $user = Auth::user();
        $this->viewData['popularSeries'] = PopularSeriesService::getPopularSeries($this->currentLocaleId);
        $this->viewData['categories'] = Category::where('locale_id', $this->currentLocaleId)->get();
        $this->viewData['user'] = $user;
        $this->viewData['interests'] = InterestUser::where('user_id', $user->id)
            ->pluck('category_id')->toArray();

        return view('web.users.interest', $this->viewData);
    }

    public function updateInterest(Request $request)
    {
        if (UserService::updateInterest(Auth::id(), $request->get('interests'))) {
            return redirect()->route('interest')->with('status', trans('web/user.profile_page.update_complete'));
        }

        return redirect()->back()->withErrors(['updated_fail' => trans('web/user.updated_fail')])->withInput($data);
    }

    public function password()
    {
        $user = Auth::user();
        if ($user->registered_by != 0) {
            $this->viewData['message_error'] = trans('web/user.profile_page.change_password_page_error', ['name' => $user->social]);
        }

        $this->viewData['popularSeries'] = PopularSeriesService::getPopularSeries($this->currentLocaleId);
        $this->viewData['user'] = $user;

        return view('web.users.password', $this->viewData);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        if (UserService::updatePassword(Auth::id(), $request->all())) {
            return redirect()->route('change_password')->with('status', trans('web/user.profile_page.update_complete'));
        }

        return redirect()->back()->withErrors(['password' => trans('web/user.password_wrong'),
            'updated_fail' => trans('web/user.updated_fail'),
            ])->withInput($request->all());
    }

    public function close()
    {
        return view('web.users.close_account');
    }

    public function closeAccount(CloseAccountRequest $request)
    {
        if (UserService::checkPassword(Auth::id(), $request->password) || Auth::user()->registeredBySocial()) {
            $user = Auth::user();
            Auth::logout();
            $user->deleteItAndRelation();

            return redirect()->route('close_complete')->with('status', 'close_account');
        } else {
            return redirect()->route('close_account')->withErrors([trans('web/user.password_wrong')]);
        }
    }

    public function closeComplete()
    {
        if (Session::has('status') && Session::get('status') == 'close_account') {
            return view('web.users.close_complete', $this->viewData);
        } else {
            return route()->redirect('index');
        }
    }
}
