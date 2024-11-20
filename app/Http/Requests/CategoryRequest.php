<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(['admin', 'editor', 'manager']); // Check if user has any role from the array

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_ar' => 'required|string|max:255|unique:categories,name_ar,' . $this->category,
            'name_en' => 'required|string|max:255|unique:categories,name_en,' . $this->category,
            'order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:categories,id', // Validate that the parent category exists
            'text_ar' => 'nullable|string',
            'text_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',  // Allows jpeg, png, jpg, gif, svg, and webp formats with a max size of 1MB
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',   // Allows jpeg, png, jpg, gif, svg, and webp formats with a max size of 1MB
            'status' => 'nullable|string|max:255',
            'link_ar' => 'nullable|string|max:255|unique:categories,link_ar,' . $this->category,
            'link_en' => 'nullable|string|max:255|unique:categories,link_en,' . $this->category,
            'mete_title_ar' => 'nullable|string|max:255',
            'mete_title_en' => 'nullable|string|max:255',
            'mete_description_ar' => 'nullable|string',
            'mete_description_en' => 'nullable|string',
            'index' => 'nullable|boolean',
        ];
    }

}
