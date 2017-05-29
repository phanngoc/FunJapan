<?php
namespace App\Services\Web;

use App\Models\PasswordReset;
use App\Models\SocialAccount;
use App\Models\User;
use App\Services\EmailService;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\InterestUser;
use Hash;

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

    public static function validateJmbInput($inputs)
    {
        $rules = [
            'first_name1' => 'required|max:10',
            'mid_name' => 'max:9',
            'password' => 'required|size:6|regex:/^[0-9]*$/|invalid_sequence_string|invalid_sequence_number|confirmed',
            'password_confirmation' => 'required|size:6',
            'address1' => 'required|max:30',
            'address2' => 'required|max:30',
            'address3' => 'max:30',
            'address4' => 'max:30',
            'city' => 'required',
            'country' => 'required',
            'zipcode' => 'required|regex:/\b\d{5}\b/',
            'phone' => 'required|regex:/^[0-9]*$/|max:20',
            'terms' => 'accepted',
        ];

        if (array_key_exists('first_name2', $inputs)) {
            $rules['first_name2'] = 'required|max:9';
        }

        if (array_key_exists('first_name3', $inputs)) {
            $rules['first_name3'] = 'required|max:9';
        }

        if (array_key_exists('last_name', $inputs)) {
            $rules['last_name'] = 'required|max:9';
        }

        $messages = [
            'first_name1.required' => trans('web/user.jmb.validate.required.first_name1'),
            'first_name1.max' => trans('web/user.jmb.validate.max.first_name1'),
            'first_name2.required' => trans('web/user.jmb.validate.required.first_name2'),
            'first_name2.max' => trans('web/user.jmb.validate.max.first_name2'),
            'first_name3.required' => trans('web/user.jmb.validate.required.first_name3'),
            'first_name3.max' => trans('web/user.jmb.validate.max.first_name3'),
            'last_name.required' => trans('web/user.jmb.validate.required.last_name'),
            'last_name.max' => trans('web/user.jmb.validate.max.last_name'),
            'mid_name.max' => trans('web/user.jmb.validate.max.mid_name'),
            'password.required' => trans('web/user.jmb.validate.required.password'),
            'password.confirmed' => trans('web/user.jmb.validate.confirmed.password'),
            'password.size' => trans('web/user.jmb.validate.size.password'),
            'password.regex' => trans('web/user.jmb.validate.regex.password'),
            'password.invalid_sequence_number' => trans('web/user.jmb.validate.invalid_sequence_number.password'),
            'password.invalid_sequence_string' => trans('web/user.jmb.validate.invalid_sequence_string.password'),
            'password_confirmation.required' => trans('web/user.jmb.validate.required.password_confirmation'),
            'password_confirmation.size' => trans('web/user.jmb.validate.size.password_confirmation'),
            'city.required' => trans('web/user.jmb.validate.required.city'),
            'country.required' => trans('web/user.jmb.validate.required.country'),
            'zipcode.required' => trans('web/user.jmb.validate.required.zipcode'),
            'zipcode.regex' => trans('web/user.jmb.validate.regex.zipcode'),
            'address1.required' => trans('web/user.jmb.validate.required.address1'),
            'address1.max' => trans('web/user.jmb.validate.max.address1'),
            'address2.required' => trans('web/user.jmb.validate.required.address2'),
            'address2.max' => trans('web/user.jmb.validate.max.address2'),
            'address3.max' => trans('web/user.jmb.validate.max.address3'),
            'address4.max' => trans('web/user.jmb.validate.max.address4'),
            'phone.required' => trans('web/user.jmb.validate.required.phone'),
            'phone.regex' => trans('web/user.jmb.validate.regex.phone'),
            'phone.max' => trans('web/user.jmb.validate.max.phone'),
            'terms.accepted' => trans('web/user.jmb.validate.accepted.terms'),
        ];

        return Validator::make($inputs, $rules, $messages)->messages()->toArray();
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
        $data['invite_code'] = uniqid(rand(), false);

        try {
            DB::beginTransaction();

            if ($data['referralId']) {
                $inviteUser = User::where('invite_code', $data['referralId'])
                    ->first();
                if ($inviteUser) {
                    //TODO : After will be process plus point
                    $data['invite_user_id'] = $inviteUser->id;
                }
            }

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
                config('user.mail_template.after_register'),
                $user->email,
                $data['locale_id'],
                ['name' => $user->name]
            );

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public static function update($id, $data)
    {
        $result = User::find($id)->update($data);

        return $result;
    }

    public static function updateInterest($id, $data)
    {
        $result = User::find($id)->interests()->sync($data);

        return $result;
    }

    /**
     * Update password for user.
     * @param  [array] $data [description]
     * @return [type]       [description]
     */
    public static function updatePassword($id, $data)
    {
        $user = User::find($id);
        if (Hash::check($data['password'], $user->password)) {
            $result = $user->update(['password' => $data['new_password']]);
            return $result;
        } else {
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

    public static function lostPassProcess($email, $localeId)
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
                config('user.mail_template.forgot_password'),
                $request->email,
                $localeId,
                [
                    'email' => $request->email,
                    'url' => action('Web\ResetPasswordController@resetPassword', ['token' => $request->token]),
                ]
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

    /**
     * Check password for user.
     * @param  [array] $data [description]
     * @return [type]       [description]
     */
    public static function checkPassword($id, $password)
    {
        $user = User::find($id);
        return Hash::check($password, $user->password);
    }
}
