<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIdeaRequest extends FormRequest
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
            'idea' => 'required|string|max:255'
        ];
    }

    public function messages()
    {
        return [
            'idea.required' => 'Ide fæltet skal være udfyldt.',
            'idea.max' => 'ideens kan ikke være længere end 255 tegn.'
        ];
    }
}
