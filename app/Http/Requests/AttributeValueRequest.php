<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttributeValueRequest extends FormRequest
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
            'status' => 'nullable|boolean', // Optional, should be a boolean value
            'value_ar' => 'required|string|max:255', // Exclude current menu record from uniqueness check
            'value_en' => 'required|string|max:255', // Exclude current menu record from uniqueness check
        ];
    }
}
