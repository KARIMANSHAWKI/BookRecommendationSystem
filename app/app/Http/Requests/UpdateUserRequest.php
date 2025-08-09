<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
	    return $this->user()->can('manage-users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Grab the User model injected by route-model binding:
        $userId = $this->route('user')->id;

        return [
            'name'     => ['sometimes', 'required', 'string', 'min:3', 'max:50'],

            // Only require email if present, and ignore this user’s own email:
            'email'    => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],

            'password' => ['sometimes', 'nullable', 'string', 'min:8', 'confirmed'],
            'phone'    => ['sometimes', 'nullable', 'string', 'regex:/^\d{10,15}$/'],
            'image'    => ['sometimes', 'nullable', 'image', 'max:6000', 'mimes:jpg,png,jpeg,svg'],
        ];
    }
}
