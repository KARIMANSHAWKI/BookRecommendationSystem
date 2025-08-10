<?php

namespace App\Domain\Services\Interfaces;

use App\Domain\DTOs\BookIntervalDTO;
use App\Models\Book;

interface IBookService
{
    public function submitUserReadingInterval(BookIntervalDTO $data);

    public function getMostRecommendedFiveBooks();

    public function assignBookToSection(array $data, Book $book);

    public function searchInGoogleBooks();
}
