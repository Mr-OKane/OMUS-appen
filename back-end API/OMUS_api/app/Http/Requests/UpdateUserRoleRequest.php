<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRoleRequest extends FormRequest
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
            'role' => "required|integer|digits_between:1,20",
        ];
    }

    public function messages()
    {
        return [
            'role.required' => "Brugeren skal have en rolle.",
            'role.digits_between' => "rollens id skal være mellem 1 og 20 cifre.",
        ];
    }
}
