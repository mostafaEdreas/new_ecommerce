<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutStrucRequest extends FormRequest
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
            'name_ar' => 'required|string|max:255|unique:menus,name_ar,'.$this->route('aboutStruc'),
            'name_en' => 'required|string|max:255|unique:menus,name_en,'.$this->route('aboutStruc'),
            'text_ar' => 'nullable|string|max:4294967295',
            'text_en' => 'nullable|string|max:4294967295',
            'status' => 'nullable|boolean',
            'parent_id' => 'nullable|exists:menus,id',
            'image' => 'nullable|image|max:1024',
            'order' => 'nullable|integer',
        ];
    }
}
