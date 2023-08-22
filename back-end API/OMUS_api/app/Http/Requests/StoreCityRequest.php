<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
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
            'city' => "required|string|max:255",
        ];
    }

    public function messages()
    {
        return [
            'city.required' => "byen skal have et navn.",
            'city.max' => 'byens navn kan ikke være mere en 255 tegn.'
        ];
    }
}
