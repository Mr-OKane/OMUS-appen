<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'status' => "required|string|in:pending,accepted,processing,dispatch,delivered",
        ];
    }

    public function messages()
    {
        return [
            'address.required' => 'ordren skal have en addresse.',
            'address.digits_between' => "ordrens addresse skal være mellem 1 og 20 cifre.",
            'status.required' => "ordren skal have en status.",
            'status.in' => "Status skal være imellem pending, accepted, processing,dispatch eller delivered.",
        ];
    }
}
