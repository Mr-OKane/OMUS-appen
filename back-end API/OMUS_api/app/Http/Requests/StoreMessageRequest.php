<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
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
            'message' => "required|string|max:1000",
            'chat' => "required|integer|digits_between:1,20"
        ];
    }

    public function messages()
    {
        return [
            'message.required' => "Der skal være skrevet noget.",
            'message.max' => "beskeden har et max på 1000 tegn.",
            'chat.required' => "beskeden kan kun skrives i en chat.",
            'chat.digits_between' => "chat'en skal værer mellem 1 og 20 cifre lang."
        ];
    }
}
