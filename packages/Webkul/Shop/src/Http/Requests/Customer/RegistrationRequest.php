<?php

namespace Webkul\Shop\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Webkul\Core\Rules\PhoneNumber;
use Webkul\Customer\Facades\Captcha;

class RegistrationRequest extends FormRequest
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
		$rules = [
			'first_name' => 'string|required',
			'email'      => 'email|required|unique:customers,email',
			'password'   => ['confirmed', 'required', Password::min(8)->numbers()->letters()],
			'birth_d' => ['required', 'numeric', 'min:1', 'max:31'],
			'birth_m' => ['required', 'numeric', 'min:1', 'max:12'],
			'birth_y' => ['required', 'numeric', 'min:1900'],
			'phone' => ['required', new PhoneNumber, 'unique:customers,phone'],
			'gender' => ['required', "in:ذكر,أنثى"],
			'area_id' => ['nullable', 'exists:areas,id'],
			'address_details' => ['required'],
		];	
        return Captcha::getValidations($rules);
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return Captcha::getValidationMessages();
    }
}
