<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Section;
use Illuminate\Http\Request;

/** @mixin \App\Models\Section */
class SectionResource extends JsonResource
{
    /** @return array<string, mixed> */
   public function toArray($request): array
   {
       /** @var Section $section */
       $section = $this->resource;

       return [
           'id'          => $this->id,
           'name'        => $this->name,
           'description' => $this->description,
           'books_count' => $this->whenCounted('books'),
           'created_at'  => $this->created_at?->toIso8601String(),
           'updated_at'  => $this->updated_at?->toIso8601String(),
       ];
   }
}
