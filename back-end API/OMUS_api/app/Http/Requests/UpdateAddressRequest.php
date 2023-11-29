<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'address' => 'required|string|max:255',
            'zipCode' => 'required|string|max:10',
        ];
    }

    public function messages()
    {
        return [
            'address.required' => "addresse fæltet skal være udfyldt.",
            'address.max' => "addressen kan ikke være længere end 255 tegn.",
            'zipCode.required' => 'addressen skal have et postnummer.',
            'zipCode.digits_between' => 'postnummeret kan max have 10 cifre'
        ];
    }
}
