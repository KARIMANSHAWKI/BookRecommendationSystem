<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignBookSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
      return $this->user()->can('assign books') || $this->user()->can('edit books');
    }

    public function rules(): array
    {
       return [
           // null = remove section
           'section_id' => ['nullable','exists:sections,id'],
       ];
    }
}
