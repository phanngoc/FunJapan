<?php
namespace App\Services\Web;

use App\Models\SocialAccount;
use App\Models\User;
use App\Services\EmailService;
use Validator;
use Illuminate\Support\Facades\DB;

class UserService
{
    public static function validate($input)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'gender' => 'required',
            'location_id' => 'required',
            'accept_policy' => 'required',
            'birthday' => 'required|date',
        ];

        $messages = [
            'name.required' => trans('web/user.validate.required.name'),
            'email.required' => trans('web/user.validate.required.email'),
            'email.email' => trans('web/user.validate.email'),
            'email.unique' => trans('web/user.validate.unique.email'),
            'password.required' => trans('web/user.validate.required.password'),
            'password.min' => trans('web/user.validate.min.password'),
            're_password.required' => trans('web/user.validate.required.re_password'),
            'gender.required' => trans('web/user.validate.required.gender'),
            'location_id.required' => trans('web/user.validate.required.location_id'),
            'accept_policy.required' => trans('web/user.validate.required.accept_policy'),
            'birthday.required' => trans('web/user.validate.required.birthday'),
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
        $data['subscription_new_letter'] = isset($data['subscription_new_letter']) ? 1 : 0;
        $data['subscription_reply_noti'] = isset($data['subscription_reply_noti']) ? 1 : 0;

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
}
