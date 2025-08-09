<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookUpdateRequest extends FormRequest
{
   public function authorize(): bool
   {
       return $this->user()->can('edit books');
   }

   public function rules(): array
   {
       return [
         'name'            => ['sometimes','required','string','max:100'],
         'description'     => ['sometimes','required','string'],
         'number_of_pages' => ['sometimes','required','integer','min:1'],
          'cover'           => ['sometimes','nullable','image','max:2048'],
           'section_id' => ['sometimes','nullable','exists:sections,id']
       ];
   }
}
