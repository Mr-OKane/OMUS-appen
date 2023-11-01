<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCakeArrangementRequest extends FormRequest
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
            'practiceDate' => "required|date_format:Y-m-d H:i:s",
            'user'=> "required|integer|digits_between:1,20"
        ];

    }

    public function messages()
    {
        return [
            'practiceDate.required' => "kageordningen skal have en dato.",
            'practiceDate.date_format' => "datoen skal være af format y-m-d H:i",
            'user.required' => "Kageordnigen skal have en bruge til datoen",
            'user.digits_between' => "Brugeren skal være mellem 1 og 20 cifre"
        ];
    }
}
