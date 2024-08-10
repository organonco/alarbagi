<?php

namespace Webkul\Shop\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
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
			'last_name'  => 'string|required',
			'email'      => 'email|required|unique:customers,email',
			'password'   => ['confirmed', 'required', Password::min(8)->numbers()->letters()],
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
