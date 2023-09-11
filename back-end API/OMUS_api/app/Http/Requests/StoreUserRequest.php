<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'password' => "required|string|min:8|max:50|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!¤£$#%&@{}$+?|<>*]).*$/|",
            'phoneNumber' => "string|max:11",
            'address' => "required|string|max:255",
            'zipCode' => "required|string|max:10",
            'city' => "required|string|max:255",
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
            'password.required' => "Brugeren skal have et password",
            'password.min' => "Brugerens kodeord skal være minium 8 tegn.",
            'password.regex' => "Brugerens kodeord skal have 1 stort 1 lille 1 tal og 1 special tegn.",
            'phoneNumber.max' => "Brugerens telefon nummer kan ikke være længere end 11 tegn.",
            'address.required' => "Brugeren skal have en addresse.",
            'address.max' => "addressen har et max på 255 tegn.",
            'zipCode.required' => "addressen skal have en postnummeret.",
            'zipCode.max' => "postnummeret har et max på 11 tegn.",
            'city.required' => "byen skal have en City.",
            'city.max' => "byen har et max på 255 tegn.",
            'role.required' => "Brugeren skal have en rolle.",
            'role.digits_between' => "rollens id skal være mellem 1 og 20 cifre.",
            'status.required' => "Brugeren skal have en status.",
            'status.digits_between' => "Status iden skal være mellem 1 og 20 cifre.",
        ];
    }
}
