<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $lang = LaravelLocalization::getCurrentLocale();
        app()->setLocale($lang);
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:png,JPEG,GIF,TIF,BMP,jpg,webp',
            'number' => 'required|integer',
            'status' => 'nullable|boolean',
        ];
    }
}
