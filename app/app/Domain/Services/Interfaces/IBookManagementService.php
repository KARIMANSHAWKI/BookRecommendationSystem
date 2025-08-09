<?php
namespace App\Domain\Services\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Book;

interface IBookManagementService
{
   public function list(int $perPage = 15): LengthAwarePaginator;
   public function get(Book $book): Book;
   public function create(array $data): Book;
   public function update(Book $book, array $data): Book;
   public function delete(Book $book): bool;
}
