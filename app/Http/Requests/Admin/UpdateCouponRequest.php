<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
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
            'name' => 'required|min:10|max:50|unique:coupons,name,' . $this->id,
            'description' => 'sometimes|min:10',
            'image' => 'image|max:' . config('images.validate.coupon_image.max_size') .
                        '|mimetypes:' . config('images.validate.coupon_image.mimes'),
            'can_get_from' => 'required|date',
            'can_get_to' => 'required|date|after:can_get_from',
            'can_use_from' => 'required|date|after_or_equal:can_get_from',
            'can_use_to' => 'required|date|after:can_use_from|after_or_equal:can_get_to',
            'max_coupon' => 'integer|min:0|max:999999999',
            'max_coupon_per_user' => 'integer|min:0|max:1000',
            'required_point' => 'integer|min:0|max:1000',
            'pin' => 'max:255',
            'pin_code' => 'max:255',
        ];
    }

    /**
     * Get attribute name
     *
     * @return array
     */
    public function attributes()
    {
        return trans('admin/coupon.label');
    }

    /**
     * Modify request value before validate
     * @return [mixed]
     */
    protected function getValidatorInstance()
    {
        $input = $this->all();
        $input['can_use_from'] = $input['can_use_from'] ?? $input['can_get_from'];
        $input['can_use_to'] = $input['can_use_to'] ?? $input['can_get_to'];

        $input['max_coupon'] = empty(ltrim($input['max_coupon'], '0')) ? 0 : ltrim($input['max_coupon'], '0');
        $input['max_coupon_per_user'] = empty(ltrim($input['max_coupon_per_user'], '0')) ? 0 : ltrim($input['max_coupon_per_user'], '0');
        $input['required_point'] = empty(ltrim($input['required_point'], '0')) ? 0 : ltrim($input['required_point'], '0');

        if (empty($input['description'])) {
            unset($input['description']);
        }

        $this->getInputSource()->replace($input);

        return parent::getValidatorInstance();
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $input = $this->all();

        if (!array_key_exists('description', $input)) {
            $input += ['description' => ''];
        }

        $this->getInputSource()->replace($input);
    }
}
