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
            'address' => "required|integer|digits_between:1,20",
            'status' => "required|string|in:pending, accepted",
            'user' => "required|integer|digits_between:1,20",
            'products' => "required|array",
            'products.*' => "required|integer|digits_between:1,20",
        ];
    }

    public function messages()
    {
        return [
            'address.required' => 'ordren skal have en addresse.',
            'address.digits_between' => "ordrens addresse skal være mellem 1 og 20 cifre.",
            'status.required' => "ordren skal have en status.",
            'status.in' => "Statusen skal være enten pending eller accepted.",
            'user.required' => "ordren skal have en bruger.",
        ];
    }

}
