<?php

namespace App\Domain\Repositories\Classes;

use App\Domain\Repositories\Interfaces\IBookRepository;
use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class BookRepository extends BaseRepository implements IBookRepository
{
    public function search(?string $search, int $perPage, int $page): LengthAwarePaginator
    {
        return Book::query()
            ->with('section')
            ->when($search !== null && $search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('id')
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
