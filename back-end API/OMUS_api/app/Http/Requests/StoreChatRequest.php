<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChatRequest extends FormRequest
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
            'name' => "required|string|max:255",
            'chatRoom' => 'required|integer|digits_between:1,20'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "chaten skal have et navn.",
            'name.max' => "chatens navn kan ikke ",
            'chatRoom.required' => "chaten skal være i et chat rum",
            'chatRoom.digits_between' => "chatens chat rum id skal være mellem 1 og 20 cifre",
        ];
    }
}
