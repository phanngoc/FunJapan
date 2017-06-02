<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        return [
            'name' => 'required|max:50',
            'gender' => 'required',
            'location_id' => 'required',
            'birthday' => 'required|date',
            'birthday_day' => 'required',
            'birthday_month' => 'required',
            'birthday_year' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => trans('web/user.validate.required.name'),
            'name.max' => trans('web/user.validate.max.name'),
            'gender.required' => trans('web/user.validate.required.gender'),
            'location_id.required' => trans('web/user.validate.required.location_id'),
            'birthday.date' => trans('web/user.validate.required.birthday'),
            'email.max' => trans('web/user.validate.max.email'),
            'birthday_day.required' => trans('web/user.validate.required.birthday_day'),
            'birthday_year.required' => trans('web/user.validate.required.birthday_year'),
            'birthday_month.required' => trans('web/user.validate.required.birthday_month'),
        ];
    }

    /**
     * Modify request value before validate
     * @return [mixed]
     */
    protected function getValidatorInstance()
    {
        $data = $this->only([
            'birthday_year',
            'birthday_month',
            'birthday_day',
            'name',
            'gender',
            'location_id',
            'religion_id',
            'subscription_new_letter',
            'subscription_reply_noti',
        ]);

        $data['birthday'] = $data['birthday_year'] . '-' . $data['birthday_month'] . '-' . $data['birthday_day'];
        $data['subscription_new_letter'] = $data['subscription_new_letter'] ? 1 : 0;
        $data['subscription_reply_noti'] = $data['subscription_reply_noti'] ? 1 : 0;

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
