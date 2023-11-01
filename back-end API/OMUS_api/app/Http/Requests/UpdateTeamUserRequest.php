<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamUserRequest extends FormRequest
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
            'user' => "required|array",
            'user.*' => "required|integer|digits_between:1,20"
        ];
    }

    public function messages()
    {
        return [
            'user.required' => "Orkestret skal have et array af brugerer",
            'user.*.required' => "Orkestret skal have en brugere",
            'user.*.digits_between' => "Brugren skal være mellem 1 og 20 cifre",
        ];
    }
}
