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
            'phoneNumber' => "string|max:11",
            'address' => "required|string|max:255",
            'zipCode' => "string|max:11",
            'city' => "string|max:255",
            'status' => "required|string|in:active,inactive",
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
            'phoneNumber.max' => "Brugerens telefon nummer kan ikke være længere end 11 tegn.",
            'address.required' => "Brugeren skal have en addresse.",
            'address.max' => "addressen har et max på 255 tegn.",
            'zipCode.required' => "addressen skal have en postnummeret.",
            'zipCode.max' => "postnummeret har et max på 11 tegn.",
            'city.required' => "byen skal have en City.",
            'city.max' => "byen har et max på 255 tegn.",
            'status.required' => "Brugeren skal have en status.",
            'status.in' => "Statusen skal være enten active eller inactive",
        ];
    }
}
