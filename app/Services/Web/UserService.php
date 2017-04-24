<?php
namespace App\Services\Web;

use App\Models\PasswordReset;
use App\Models\SocialAccount;
use App\Models\User;
use App\Services\EmailService;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\DB;

class UserService
{
    public static function validate($input)
    {
        $rules = [
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|email_update|unique:users,email',
            'gender' => 'required',
            'location_id' => 'required',
            'accept_policy' => 'required',
            'birthday' => 'required|date',
        ];

        if (!$input['registered_by']) {
            $rules['password'] =  'required|min:6|max:50|confirmed';
            $rules['password_confirmation'] = 'required|min:6|max:50';
        }

        $messages = [
            'name.required' => trans('web/user.validate.required.name'),
            'name.max' => trans('web/user.validate.max.name'),
            'email.required' => trans('web/user.validate.required.email'),
            'email.email' => trans('web/user.validate.email'),
            'email.email_update' => trans('web/user.validate.email'),
            'email.unique' => trans('web/user.validate.unique.email'),
            'password.required' => trans('web/user.validate.required.password'),
            'password.min' => trans('web/user.validate.min.password'),
            'gender.required' => trans('web/user.validate.required.gender'),
            'location_id.required' => trans('web/user.validate.required.location_id'),
            'accept_policy.required' => trans('web/user.validate.required.accept_policy'),
            'birthday.required' => trans('web/user.validate.required.birthday'),
            'birthday.date' => trans('web/user.validate.required.birthday'),
            'password_confirmation.required' => trans('web/user.validate.required.password_confirmation'),
            'email.max' => trans('web/user.validate.max.email'),
            'password.max' => trans('web/user.validate.max.password'),
            'password_confirmation.max' => trans('web/user.validate.max.password_confirmation'),
        ];

        return Validator::make($input, $rules, $messages)->messages()->toArray();
    }

    public static function loginValidate($input)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];

        $messages = [
            'email.required' => trans('web/user.validate.required.email'),
            'email.email' => trans('web/user.validate.email'),
            'password.required' => trans('web/user.validate.required.password'),
            'password.min' => trans('web/user.validate.min.password'),
        ];

        return Validator::make($input, $rules, $messages)->messages()->toArray();
    }

    public static function confirmPassValidate($input)
    {
        return self::loginValidate($input);
    }

    public static function create($data)
    {
        $data['point'] = config('user.default_point');

        try {
            DB::beginTransaction();

            $user =  User::create($data);
            if ($data['social_id']) {
                SocialAccount::create([
                    'user_id' => $user->id,
                    'provider_user_id' => $data['social_id'],
                    'provider' => $data['provider'],
                ]);
            }

            DB::commit();

            EmailService::sendMail(
                'user.register_email',
                $user->email,
                trans('web/email.register_mail_subject'),
                ['name' => $user->name]
            );

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public static function validateSocialUser($socialUser)
    {
        $social = SocialAccount::getSocial($socialUser->getId(), config('user.social_provider.facebook'));
        if ($social) {
            return [
                'success' => true,
                'data' => $social->user,
            ];
        }

        $data['email'] = $socialUser->getEmail();
        $user = User::getByCondition($data, true);

        if (!$user) {
            return [
                'success' => false,
                'social_id' => $socialUser->getId(),
                'email' => $socialUser->getEmail(),
                'name' => $socialUser->getName(),
            ];
        }

        return [
            'success' => false,
            'user_id' => $user->id,
            'social_id' => $socialUser->getId(),
        ];
    }

    public static function updateSocial($userId, $data)
    {
        return SocialAccount::create([
            'user_id' => $userId,
            'provider_user_id' => $data['social_id'],
            'provider' => $data['provider'],
        ]);
    }

    public static function loginViaEmail($input)
    {
        $user = User::getByCondition($input, true);

        return $user;
    }

    public static function find($userId)
    {
        return User::find($userId);
    }

    public static function validateLostPass($input)
    {
        $rules = [
            'email' => 'required|email|exists:users,email',
        ];

        $messages = [
            'email.required' => trans('web/user.validate.required.email'),
            'email.email' => trans('web/user.validate.email'),
            'email.exists' => trans('web/user.validate.exists.email'),
        ];

        $validate = Validator::make($input, $rules, $messages)->messages();

        if (count($validate)) {
            return $validate;
        }

        $user = User::getByCondition($input, true);
        if ($user->registered_by) {
            return ['email_facebook' => trans('web/user.lost_password.email_facebook')];
        }

        return [];
    }

    public static function lostPassProcess($email)
    {
        try {
            DB::beginTransaction();
            $user = User::getByCondition(['email' => $email], true);

            PasswordReset::where('email', $email)->delete();

            $a = md5(uniqid(rand(), true));
            $request = PasswordReset::create([
                'user_id' => $user->id,
                'email' => $email,
                'token' => $a,
            ]);

            EmailService::sendMail(
                'user.lost_password',
                $request->email,
                trans('web/email.lost_password_mail_subject'),
                ['email' => $request->email, 'token' => $request->token]
            );

            DB::commit();

            return $request;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public static function checkToken($token)
    {
        $request = PasswordReset::where('token', $token)->first();

        if ($request && Carbon::now()->gt($request->created_at->addDays(config('user.token_expire')))) {
            return false;
        }

        return $request;
    }

    public static function validateResetPassword($input)
    {
        $rules = [
            'password' => 'required|min:6|max:50|confirmed',
            'password_confirmation' => 'required',
            'token' => 'required',
        ];

        $messages = [
            'password.required' => trans('web/user.validate.required.password'),
            'password.min' => trans('web/user.validate.min.password'),
            'password.max' => trans('web/user.validate.max.password'),
            'password_confirmation.required' => trans('web/user.validate.required.password_confirmation'),
            'token.required' => trans('web/user.token_not_found'),
        ];

        return Validator::make($input, $rules, $messages)->messages()->toArray();
    }

    public static function resetPassword($requestReset, $newPassword)
    {
        try {
            DB::beginTransaction();

            $user = User::find($requestReset->user_id);
            $user->password = $newPassword;
            $user->save();

            $requestReset->delete();

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
