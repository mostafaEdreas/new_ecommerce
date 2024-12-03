<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = $this->route('user');
        return [
           'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:users,phone,' . $userId,
            'email' => 'nullable|email|max:255|unique:users,email,' . $userId,
            'image' => 'nullable|image|max:2048', // Ensure valid image file
            'them' => 'nullable|string|max:255',
            'password' => $this->isMethod('post') ? 'required|string|min:8' : 'nullable|string|min:8',
            'is_admin' => 'nullable|boolean',
            'admin_seen' => 'nullable|boolean',
            'role' =>'nullable|array',

        ];
    }
}
