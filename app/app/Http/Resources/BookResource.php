<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
   public function toArray($request): array
   {
      return [
          'id'              => $this->id,
          'name'            => $this->name,
          'description'     => $this->description,
          'number_of_pages' => $this->number_of_pages,
          'cover_url'       => $this->cover ? asset('storage/'.$this->cover) : null,
          'section_id' => $this->section_id,
          'section'    => $this->whenLoaded('section', fn() => [
              'id' => $this->section->id,
              'name' => $this->section->name,
          ]),
          'created_at'      => $this->created_at->toIso8601String(),
          'updated_at'      => $this->updated_at->toIso8601String(),
      ];
   }
}
