<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'description' => "string|max:4000",
            'image' => "image",
            'price' => "required|decimal:2,2|max:10000000",
            'amount' => "required|int|max:100000",
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Produktet skal have et navn",
            'name.max' => "produktets navn skal være mindere end 255 tegn",
            'description.max' => "beskrivelsen skal mindre end 4000 tegn",
            'image.image' => "billedet skal være af type jpg, jpeg eller png",
            'price.required' => "produktet skal have en price.",
            'price.max' => "prisen skal være mindre end en 1000000",
        ];
    }
}
