<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
   public function toArray($request): array
   {
       return [
         'id'          => $this->id,
         'name'        => $this->name,
         'description' => $this->description,
         'books_count' => $this->whenCounted('books'),
         'created_at'  => $this->created_at->toIso8601String(),
         'updated_at'  => $this->updated_at->toIso8601String(),
       ];
   }
}
