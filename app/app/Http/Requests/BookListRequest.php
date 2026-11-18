<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('view books') ?? false;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:100'],
            'per_page' => ['sometimes', 'required', 'integer', 'min:1', 'max:100'],
            'page' => ['sometimes', 'required', 'integer', 'min:1', 'max:10000'],
        ];
    }
}
