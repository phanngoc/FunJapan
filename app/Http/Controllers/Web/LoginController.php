<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Symfony\Component\HttpFoundation\Request;
use App\Services\Web\UserService;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        return view('web.users.login');
    }

    public function postLogin(Request $request)
    {
        $input = $request->only(['email', 'password']);

        $validate = UserService::loginValidate($input);
        if (count($validate)) {
            return redirect()->back()->withErrors($validate)->withInput($input);
        }

        $isLogin = auth()->attempt($input);

        if (!$isLogin) {
            return redirect()->back()
                ->withErrors(['login_fail' => trans('web/user.login_fail')])
                ->withInput($input);
        }

        return redirect('/');
    }
}
