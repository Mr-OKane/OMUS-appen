<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPasswordRequest extends FormRequest
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
            "password" => ['Required','string','min:8','max:50','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!¤£$#%&@{}$+?|<>*]).*$/'],
            "repeatPassword" => ['Required','string','min:8','max:50','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!¤£$#%&@{}$+?|<>*]).*$/']
        ];
    }

    public function messages()
    {
        return [
            'password.required' => "Kodeordet skal være udfyldt",
            'password.min' => "Koden skal være minimum 8 cifre",
            'password.max' => "Koden må max være 50 cifre lang",
            'password.regex' => "Andgangskoden skal indeholde minimum 1 lille og stort bugstav, 1 tal og 1 special tegn",
        ];
    }
}
