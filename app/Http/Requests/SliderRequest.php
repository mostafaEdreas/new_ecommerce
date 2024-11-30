<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'text_ar' => 'nullable|string|max:4294967295',
            'text_en' => 'nullable|string|max:4294967295',
            'video_link' => 'nullable|url|required_without:image',
            'image' => 'nullable|image|max:255|required_without:video_link',
            'order' => 'nullable|integer|default:1',
            'type' => 'nullable|string|max:50',
            'status' => 'nullable|boolean|default:0',
        ];
    }
}
