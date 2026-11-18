<?php

namespace App\Domain\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IBookRepository
{
    public function search(?string $search, int $perPage, int $page): LengthAwarePaginator;
}
