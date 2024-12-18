<?php

namespace App\Http\Requests;

use App\Models\Slider;
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
            'text_ar' => 'nullable|string|max:500',
            'text_en' => 'nullable|string|max:500',
            'video_link' => $this->isMethod('post') ? 'nullable|url|required_without:image' : 'nullable|url' ,
            'image' => $this->isMethod('post') ?'nullable|image|max:1024|required_without:video_link': 'nullable|image|max:1024' ,
            'order' => 'nullable|integer',
            'type' => 'nullable|string|max:50|in:' . implode(',', Slider::TYPES),
            'status' => 'nullable|in:1',
        ];
    }
}
