<?php
namespace App\Domain\Services\Classes;

use App\Domain\Services\Interfaces\IBookManagementService;
use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookManagementService implements IBookManagementService
{
   public function list(int $perPage = 15): LengthAwarePaginator
   {
       return Book::with('section')->paginate($perPage);
   }

   public function get(Book $book): Book
   {
       return $book->load('section');
   }

   public function create(array $data): Book
   {
       return Book::create($data); // section_id allowed, nullable
   }

   public function update(Book $book, array $data): Book
   {
       $book->update($data);
       return $book->load('section');
   }

   public function delete(Book $book): bool
   {
       return $book->delete();
   }
}
