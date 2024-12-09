<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
            'stock' => 'required|integer|min:1',  // Ensure stock is a positive integer
            'price' => 'required|numeric|min:0',  // Ensure price is a positive number
            'values' => 'nullable|array|min:1',  // Ensure at least one attribute value is selected
            'values.*' => 'required|exists:product_attribute_values,id'  // Ensure each selected value exists in the attribute_values table
        ];
    }
}
