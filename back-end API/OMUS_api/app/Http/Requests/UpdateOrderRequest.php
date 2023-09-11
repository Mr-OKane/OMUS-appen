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
            'status' => "required|integer|digits_between:1,20",
            'user' => "required|integer|digits_between:1,20",
            'orderDate' => "required|date_format:Y-m-d\TH:i"
        ];
    }

    public function messages()
    {
        return [
            'address.required' => 'ordren skal have en addresse.',
            'address.digits_between' => "ordrens addresse skal være mellem 1 og 20 cifre.",
            'status.required' => "ordren skal have en status.",
            'status.digits_between' => "ordrens status skal være mellem 1 og 20 cifre.",
            'user.required' => "ordren skal have en bruger.",
            'orderDate.required' => "orderen skal have en dato på hvornår den er købt.",
            'orderDate.date_format' => "datoen skal være en datetime."
        ];
    }
}
