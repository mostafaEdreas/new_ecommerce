<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:coupons,code,' . $this->route('coupon'),
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_use' => 'required|integer|min:1',
            'min_price' => 'required|integer|min:0',
            'discount' => 'required|numeric|min:0',
            'discount_type' => 'required|boolean',
            'type' => 'nullable|string|in:general,specific',
        ];
    }
}
