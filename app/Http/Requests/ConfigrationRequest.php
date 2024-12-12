<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigrationRequest extends FormRequest
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
            'app_name' => 'required|string|max:255',
            'top_text' => 'nullable|string',
            'about_app' => 'nullable|string',
            'logo' => 'nullable|file|image|mimes:jpeg,png,gif,bmp,webp|max:2048',
            'logo_footer' => 'nullable|file|image|mimes:jpeg,png,gif,bmp,webp|max:2048',
            'favicon' => 'nullable|file|image|mimes:jpeg,png,gif,bmp,webp|max:1024',
            'inspection_image' => 'nullable|file|image|mimes:jpeg,png,gif,bmp,webp|max:2048',
            'address1' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'place_order_msg' => 'nullable|string',
        ];
    }
}
