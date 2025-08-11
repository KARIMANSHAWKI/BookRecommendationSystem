<?php

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Book */
class BookResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray($request): array
   {
       /** @var Book $book */
       $book = $this->resource;

       return [
           'id'              => $book->id,
           'name'            => $book->name,
           'description'     => $book->description,
           'number_of_pages' => $book->number_of_pages,
           'cover_url'       => $book->cover ? asset('storage/'.$book->cover) : null,
           'section_id'      => $book->section_id,
           'section'         => $this->whenLoaded('section', function () use ($book) {
               $section = $book->section; // relation is loaded when this runs
               return $section ? [
                   'id'   => $section->id,
                   'name' => $section->name,
               ] : null;
           }),
           'created_at'      => $book->created_at?->toIso8601String(),
           'updated_at'      => $book->updated_at?->toIso8601String(),
       ];
   }
}
