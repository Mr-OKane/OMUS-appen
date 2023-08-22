<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'firstname' => "required|string|max:255",
            'lastname' => "required|string|max:255",
            'email' => "required|email:rfc",
            'phoneNumber' => "required|string|max:11",
            'address' => "required|integer|digits_between:1,20",
            'role' => "required|integer|digits_between:1,20",
            'status' => "required|integer|digits_between:1,20",
        ];
    }

    public function messages()
    {
        return [
            'firstname.required' => "Brugeren skal have et fornavn, med mellemnavne.",
            'firstname.max' => "Brugerens fornavn og mellemnavne kan ikke være længere end 255 tegn.",
            'lastname.required' => "Brugeren skal have en efternavn.",
            'lastname.max' => "Brugens efternavn kan ikke være længere end 255 tegn.",
            'email.required' => "Brugeren skal have en email.",
            'email.max' => "Brugerens email kan ikke være længere end 255 tegn.",
            'phoneNumber.required' => "Brugerens skal have et telefon nummmer.",
            'phoneNumber.max' => "Brugerens telefon nummer kan ikke være længere end 11 tegn.",
            'address.required' => "Brugeren skal have en addresse.",
            'address.digits_between' => "Addressens id skal være mellem 1 og 20 cifre.",
            'role.required' => "Brugeren skal have en rolle.",
            'role.digits_between' => "rollens id skal være mellem 1 og 20 cifre.",
            'status.required' => "Brugeren skal have en status.",
            'status.digits_between' => "Status iden skal være mellem 1 og 20 cifre.",
        ];
    }
}
