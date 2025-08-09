<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionStoreRequest extends FormRequest
{
   public function authorize(): bool
   {
      return $this->user()->can('create sections');
   }

   public function rules(): array
   {
       return [
          'name' => ['required','string','max:100','unique:sections,name'],
          'description' => ['nullable','string'],
       ];
   }
}
