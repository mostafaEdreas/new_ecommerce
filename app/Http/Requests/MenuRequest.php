<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'name_ar' => 'required|string|max:255|unique:menus,name_ar,'.$this->route('menu'),
            'name_en' => 'required|string|max:255|unique:menus,name_en,'.$this->route('menu'),
            'status' => 'nullable|boolean',
            'parent_id' => 'nullable|exists:menus,id',
            'segment' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255|in:main,about', // Adjust allowed types if needed
            'order' => 'nullable|integer|min:1',
        ];
    }
}
