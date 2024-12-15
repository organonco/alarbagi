<?php

namespace Webkul\Shop\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Webkul\Core\Rules\Address;
use Webkul\Core\Rules\AlphaNumericSpace;
use Webkul\Core\Rules\PhoneNumber;
use Webkul\Customer\Rules\VatIdRule;

class AddressRequest extends FormRequest
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
            'name' => ['required'],
            'phone'   => ['required', new PhoneNumber],
            'area_id'    => ['nullable', 'exists:areas,id'],
            'address_details'     => ['nullable', 'max:1000'],
            'lng' => ['nullable'],
            'lng' => ['nullable']
        ];
    }
}
