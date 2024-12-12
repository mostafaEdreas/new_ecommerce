<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Set to false if authorization is required.
    }

    public function rules()
    {

        return [
            'name_ar' => 'required|string|max:255|unique:products,name_ar,' . $this->route('product'),
            'name_en' => 'required|string|max:255|unique:products,name_en,' . $this->route('product'),
            'code' => 'nullable|string|max:10|unique:products,code,' . $this->route('product'),
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'order' => 'required|integer',
            'text_ar' => 'nullable|string',
            'text_en' => 'nullable|string',
            'short_text_ar' => 'nullable|string',
            'short_text_en' => 'nullable|string',
            'main_image' => $this->isMethod('post') ? 'required|image|mimes:jpeg,png,gif,bmp,webp|max:1024' : 'nullable|image|mimes:jpeg,png,gif,bmp,webp|max:1024',
            'second_image' => $this->isMethod('post') ? 'required|image|mimes:jpeg,png,gif,bmp,webp|max:1024' : 'nullable|image|mimes:jpeg,png,gif,bmp,webp|max:1024',
            'icon' => 'nullable|string|max:255',
            'status' => 'nullable|in:0,1', // Validate as 0 or 1
            'link_ar' => 'required|string|max:255|unique:products,link_ar,' . $this->route('product'),
            'link_en' => 'required|string|max:255|unique:products,link_en,' . $this->route('product'),
            'mete_title_ar' => 'nullable|string|max:255',
            'mete_title_en' => 'nullable|string|max:255',
            'mete_description_ar' => 'nullable|string',
            'mete_description_en' => 'nullable|string',
            'index' => 'nullable|boolean',
            'attributes' => 'nullable|array|min:1',
            'attributes.*' => 'required|exists:attributes,id',

        ];
    }
}
