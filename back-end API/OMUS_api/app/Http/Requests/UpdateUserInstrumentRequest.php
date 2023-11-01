<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserInstrumentRequest extends FormRequest
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
            'instrument' => 'required|array|max:3',
            'instrument.*' => 'required|integer|digits_between:1,20',
        ];
    }

    public function messages()
    {
        return [
            'instrument.required' => "En bruger skal have et instrument.",
            'instrument.max' => "Man spiller ikke på mere end 3 instrumenter.",
            'instrument.*.digits_between' => "Instrumentet har et max på 20 cifre."
        ];
    }
}
