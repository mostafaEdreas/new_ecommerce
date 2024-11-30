<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust according to your authorization logic
    }

    public function rules()
    {
        return [
            'address' => 'required|string|max:255', 
            'land_mark' => 'required|string|max:255', // Unique landmark
            'country_id' => 'required|exists:countries,id', // Country must exist
            'region_id' => 'required|exists:regions,id', // Region must exist
            'area_id' => 'required|exists:areas,id', // Area must exist
            'phone' => 'required|string|max:20', // Unique phone number
            'is_primary' => 'nullable|boolean', // Primary address flag
            'status' => 'nullable|boolean', // Status flag
        ];
    }

}
