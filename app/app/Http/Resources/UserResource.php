<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource  extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'book_id' => $this['book_id'],
            'book_name' => $this['book_name'],
            'num_of_read_pages' => $this['num_of_read_pages']
        ];
    }
}
