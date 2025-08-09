<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SectionUpdateRequest extends FormRequest
{
   public function authorize(): bool
   {
       return $this->user()->can('edit sections');
   }

   public function rules(): array
   {
       return [
           'name'        => ['sometimes','required','string','max:100', Rule::unique('sections','name')->ignore($this->section)],
           'description' => ['sometimes','nullable','string'],
       ];
   }
}
