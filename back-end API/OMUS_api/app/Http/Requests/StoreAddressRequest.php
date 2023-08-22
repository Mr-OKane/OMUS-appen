<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'address|required|string|max:255',
            'zipCode|required|integer|digits_between:1,20',
        ];
    }

    public function messages()
    {
        return [
            'address.required' => "addresse fæltet skal være udfyldt.",
            'address.max' => "addressen kan ikke være længere end 255 tegn.",
            'zipCode.required' => 'addressen skal have et postnummer.',
            'zipCode.digits_between' => 'postnummers id skal mellem 1 og 20 cifre'
        ];
    }
}
