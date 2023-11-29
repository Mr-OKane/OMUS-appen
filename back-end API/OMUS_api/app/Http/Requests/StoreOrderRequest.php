<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'address' => "required|string|max:255",
            'zipCode' => "required|string|max:10",
            'city' => "required|string|max:255",
            'status' => "required|string|in:pending, accepted",
            'user' => "required|integer|digits_between:1,20",
            'products' => "required|array",
            'products.*' => "required|integer|digits_between:1,20",
        ];
    }

    public function messages()
    {
        return [
            'address.required' => "Brugeren skal have en addresse.",
            'address.max' => "addressen har et max på 255 tegn.",
            'zipCode.required' => "addressen skal have en postnummeret.",
            'zipCode.max' => "postnummeret har et max på 11 tegn.",
            'city.required' => "byen skal have en City.",
            'city.max' => "byen har et max på 255 tegn.",
            'status.required' => "ordren skal have en status.",
            'status.in' => "Statusen skal være enten pending eller accepted.",
            'user.required' => "ordren skal have en bruger.",
        ];
    }

}
