<?php

declare(strict_types=1);

namespace App\Domain\DTOs;

use Illuminate\Database\Eloquent\Model;

class BookIntervalDTO extends DataTransferObject
{
    public int $book_id;
    public int $start_page;
    public int $end_page;


    public static function fromRequest(array|Model $request): DataTransferObject
    {
        return new self([
            'book_id' => optional($request)['book_id'],
            'start_page' => optional($request)['start_page'],
            'end_page' => optional($request)['end_page'],]);
    }
}
