<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'required|boolean',
            'address_id' => 'required|exists:addresses,id',
            'user_id' => 'required|exists:users,id',
            'payment_id' => 'nullable|exists:payments,id',
            'shipping_id' => 'nullable|exists:shippings,id',
            'products_price' => 'required|numeric|min:0',
            'coupon_id' => 'nullable|exists:coupons,id',
            'payment_status' => 'required|boolean',
            'note' => 'nullable|string|max:65535',
            'admin_seen' => 'required|boolean',
            'delivery_date' => 'nullable|date|after_or_equal:today',
        ];
    }
}
