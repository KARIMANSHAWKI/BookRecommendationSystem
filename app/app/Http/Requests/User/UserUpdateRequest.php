<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->route('user'); // Or whatever route model binding you're using

        return $this->user()->hasPermission('update-user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:30|min:5',
            'email' => 'sometimes|string|email|max:60|unique:users,email',
            'password' => 'sometimes|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'phone' => 'sometimes|string|regex:/^\d{10,15}$/',
            'image' => 'sometimes|image|max:6000|mimes:jpg,png,jpeg,svg',
        ];
    }
}
