<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
           'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'discount' => 'required|numeric|min:0|max:999999.99',
            'type' => 'nullable|boolean',
            'product_id' => 'required|exists:products,id',
            'discount_id' => $this->isMethod('post') ? 'nullable|exists:discounts,id': 'nullable|exists:discounts,id',
        ];
    }
}
