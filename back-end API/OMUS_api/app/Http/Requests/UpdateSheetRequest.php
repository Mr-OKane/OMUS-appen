<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSheetRequest extends FormRequest
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
            'user' => "required|integer|digits_between:1,20",
            'pdf' => "required|file"
        ];
    }

    public function messages()
    {
        return [
            'user.required' => "Der skal være en bruger koblet sammen med pdf'en.",
            'user.digits_between' => "brugerens id skal være mellem 1 og 20 cifre.",
            'pdf.required' => "Der skal være en PDF fil",
            'pdf.file' => "Filen er ikke uploaded ordenligt."
        ];
    }
}
