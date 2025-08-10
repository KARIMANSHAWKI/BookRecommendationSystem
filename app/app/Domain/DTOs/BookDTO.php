<?php

declare(strict_types=1);

namespace App\Domain\DTOs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class BookDTO extends DataTransferObject
{
    public string $name;

    public string $description;
    public string $number_of_pages;

    public int $section_id;
    public int $created_by;
    public string $cover;


    public static function fromRequest(array|Model $request): DataTransferObject
    {
        return new self([
            'name' => optional($request)['name'],
            'section_id' =>  optional($request)['section_id'],
            'created_by' =>  auth()->id(),
            'number_of_pages' => optional($request)['number_of_pages'],
            'description' => optional($request)['description'],
            'cover' => optional($request)['cover'] ? uploadImage($request['cover']) : null,
        ]);
    }
}
