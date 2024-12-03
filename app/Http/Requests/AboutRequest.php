<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return  true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title_en' => 'required|string|max:255',
            'text_en' => 'nullable|string|max:4294967295',
            'title_ar' => 'required|string|max:255',
            'text_ar' => 'nullable|string|max:4294967295',
            'image' => 'nullable|image|max:1024', // Optional image validation
            'video_link' => 'nullable|string|max:255',
            'banner' => 'nullable|image|max:3072', // Optional image validation

        ];
    }
}
