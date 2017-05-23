<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Symfony\Component\HttpFoundation\Request;

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

    protected function sendLoginResponse(Request $request)
    {
        $user = $this->guard()->user();

        if (!$user->isAccessAdmin()) {
            $this->guard()->logout();

            return abort(403, 'Unauthorized action.');
        }

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $user)
            ?: redirect()->intended($this->redirectPath());
    }

    protected function validateLogin(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ],
            [
                'email.required' => trans('admin/user.validate.required.email'),
                'email.email' => trans('admin/user.validate.email'),
                'password.required' => trans('admin/user.validate.required.password'),
                'password.min' => trans('admin/user.validate.min.password'),
            ]
        );
    }

    public function showLoginForm()
    {
        return view('admin.users.login');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('admin/user.login_fail')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect()->back();
    }
}
