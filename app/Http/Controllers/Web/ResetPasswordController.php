<?php

namespace App\Http\Controllers\Web;

use Symfony\Component\HttpFoundation\Request;
use App\Services\Web\UserService;

class ResetPasswordController extends Controller
{
    public function lostPassWord()
    {
        return view('web.users.lost_password');
    }

    public function lostPassWordProcess(Request $request)
    {
        $input = $request->only('email');

        $validate = UserService::validateLostPass($input);
        if (count($validate)) {
            return redirect()->back()->withErrors($validate)->withInput($input);
        }

        if (!UserService::lostPassProcess($input['email'])) {
            return redirect()->back()->withErrors(['updated_fail' => trans('web/user.updated_fail')]);
        }

        return view('web.users.lost_password_requested');
    }

    public function resetPassword($token)
    {
        $checkToken = UserService::checkToken($token);
        $this->viewData['token'] = $token;

        if (!$checkToken) {
            return view('web.users.reset_password', $this->viewData)->withErrors(['token' => trans('web/user.token_not_found')]);
        }

        return view('web.users.reset_password', $this->viewData);
    }

    public function resetPasswordProcess(Request $request)
    {
        $input = $request->only(['password', 'password_confirmation', 'token']);

        $validate = UserService::validateResetPassword($input);

        if (count($validate)) {
            return redirect()->back()->withErrors($validate);
        }

        $checkToken = UserService::checkToken($input['token']);

        if (!$checkToken) {
            return redirect()->back()->withErrors(['token' => trans('web/user.token_not_found')]);
        }

        if (UserService::resetPassword($checkToken, $input['password'])) {
            return redirect()->action('Web\LoginController@showLoginForm');
        }

        return redirect()->back()->withErrors(['updated_fail' => trans('web/user.updated_fail')]);
    }
}
