<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePracticeDateRequest extends FormRequest
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
            'practiceDate' => "required|date_format:Y-m-d H:i:s"
        ];
    }

    public function messages(): array
    {
        return [
            'practiceDate.required' => "øve datoen skal være valgt.",
            'practiceDate.date_format' => "datoen skal være af format Y-m-d H:i:s"
        ];
    }
}
