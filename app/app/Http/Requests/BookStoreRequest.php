<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
{
   public function authorize(): bool
   {
       return $this->user()->can('create books');
   }

   public function rules(): array
   {
       return [
           'name'            => ['required','string','max:100'],
           'description'     => ['required','string'],
           'number_of_pages' => ['required','integer','min:1'],
           'cover'           => ['nullable','image','max:2048'],
           'section_id' => ['nullable','exists:sections,id']
       ];
   }
}
