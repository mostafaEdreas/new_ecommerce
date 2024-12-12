<?php

namespace App\Http\Requests;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'lang' => 'nullable|in:en,ar',
            'contact_email' => 'nullable|email|max:255',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|numeric|digits_between:8,15',
            'mobile' => 'nullable|numeric|digits_between:8,15',
            'fax' => 'nullable|numeric|digits_between:8,15',
            'whatsapp' => 'nullable|numeric|digits_between:8,15',
            'snapchat' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:500',
            'linkedin' => 'nullable|url|max:500',
            'instgram' => 'nullable|url|max:500',
            'twitter' => 'nullable|url|max:500',
            'map_url' => 'nullable|url|max:1000',
            'place_order_msg' => 'nullable|string|max:1000',
            'shipping_status' => 'required|string|max:50|min:2',
            'shipping_fees' => 'required|numeric|min:0',
            'shipping_free_in_status' => 'required|boolean|in:0,1',
            'shipping_free_in_amount' => 'required_if:shipping_free_in_status,1|numeric',

        ];



    }
}
