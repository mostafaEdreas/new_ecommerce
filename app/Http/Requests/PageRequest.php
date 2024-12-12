<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'title_ar' => 'required|string|unique:your_table_name,title_ar|max:255',
            'title_en' => 'required|string|unique:your_table_name,title_en|max:255',
            'text_ar' => 'required|string',
            'text_en' => 'required|string',
            'link_ar' => 'required|string|unique:your_table_name,link_ar|max:255',
            'link_en' => 'required|string|unique:your_table_name,link_en|max:255',
            'mete_title_ar' => 'nullable|string|max:255',
            'mete_title_en' => 'nullable|string|max:255',
            'mete_description_ar' => 'nullable|string',
            'mete_description_en' => 'nullable|string',
            'status' => 'nullable|in:0,1', // Assuming status is either 0 or 1
        ];
    }
}
