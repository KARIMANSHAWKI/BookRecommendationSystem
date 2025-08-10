<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class GoogleBooksResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'title' => Arr::get($this, 'title'),
            'author' => Arr::get($this, 'author'),
            'pageCount' => Arr::get($this, 'pageCount'),
            'images' => Arr::get($this, 'images'),
            'book_url' => Arr::get($this, 'book_url'),
        ];
    }
}
