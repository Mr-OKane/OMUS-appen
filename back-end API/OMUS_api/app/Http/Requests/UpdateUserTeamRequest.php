<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserTeamRequest extends FormRequest
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
            'team' => "required|array",
            'team.*' => "required|integer|digits_between:1,20",
        ];
    }

    public function messages()
    {
        return [
            'team.required' => "brugeren skal have en array af orkestrers.",
            'team.*.required' => "brugeren skal have et orkestre.",
            'team.*.digits_between' => "orkestret skal være mellem 1 og 20 cifre."
        ];
    }
}
