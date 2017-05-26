<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class CloseAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (!Auth::user()->registeredBySocial()) {
            $rules = [
                'password' => 'required|min:6|max:50',
                'confirm_password' => 'required|min:6|max:50|same:password',
            ];
        } else {
            $rules = [];
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.required' => trans('web/user.validate.required.password'),
            'password.max' => trans('web/user.validate.max.password'),
            'password.min' => trans('web/user.validate.min.password'),

            'confirm_password.required' => trans('web/user.validate.required.password_confirmation'),
            'confirm_password.max' => trans('web/user.validate.max.password_confirmation'),
            'confirm_password.same' => trans('web/user.validate.same.password_confirmation'),
            'confirm_password.min' => trans('web/user.validate.min.password_confirmation'),
        ];
    }
}
