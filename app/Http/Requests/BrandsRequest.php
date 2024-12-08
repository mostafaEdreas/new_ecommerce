<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Check if user has any role from the array

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_ar' => 'required|string|max:255|unique:categories,name_ar,' . $this->route('brand'),
            'name_en' => 'required|string|max:255|unique:categories,name_en,' . $this->route('brand'),
            'order' => 'nullable|integer',
            'text_ar' => 'nullable|string',
            'text_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:JPEG,PNG,GIF,BMP,WebP|max:1024',  // Allows jpeg, png, jpg, gif, svg, and webp formats with a max size of 1MB
            'icon' => 'nullable|image|mimes:JPEG,PNG,GIF,BMP,WebP|max:1024',   // Allows jpeg, png, jpg, gif, svg, and webp formats with a max size of 1MB
            'status' => 'nullable|string|max:255',
            'link_ar' => 'required|string|max:255|unique:categories,link_ar,' .$this->route('brand'),
            'link_en' => 'required|string|max:255|unique:categories,link_en,' . $this->route('brand'),
            'mete_title_ar' => 'nullable|string|max:255',
            'mete_title_en' => 'nullable|string|max:255',
            'mete_description_ar' => 'nullable|string',
            'mete_description_en' => 'nullable|string',
            'index' => 'nullable|boolean',
        ];
    }

}
