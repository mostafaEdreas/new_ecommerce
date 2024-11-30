<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class ValueDeleteRequest extends FormRequest
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
            'value_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $exists = DB::table('product_attributes')->where('attribute_value_id', $value)->exists();
                    if ($exists) {
                        $fail(__('home.Cannot delete value because it is related to another table'));
                    }
                },
            ],
        ];
    }
}
