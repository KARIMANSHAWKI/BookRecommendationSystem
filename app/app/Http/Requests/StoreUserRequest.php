<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        return [
	        'name'     => ['required', 'string', 'min:3', 'max:50'],
	        'email'    => ['required', 'email', 'unique:users,email'],
	        'password' => ['required', 'string', 'min:8', 'confirmed'],
	        'phone'    => ['nullable', 'string', 'regex:/^\d{10,15}$/'],
	        'image'    => ['nullable', 'image', 'max:6000', 'mimes:jpg,png,jpeg,svg'],
        ];
    }
}
