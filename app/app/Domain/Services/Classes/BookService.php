<?php

namespace App\Domain\Services\Classes;

use App\Domain\Services\Interfaces\IBookService;
use App\Models\Book;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;

class BookService implements IBookService
{

    public function submitUserReadingInterval(array $data): \Illuminate\Foundation\Application|array|string|Translator|Application|null
    {
        $book = Book::where('id', $data['book_id'])->first();
        $book->users()->attach(auth()->id(), [
            'start_page' => $data['start_page'],
            'end_page' => $data['end_page']
        ]);

        return trans('message.interval-submitted-successfully');
    }

    public function getMostRecommendedFiveBooks()
    {
        $books = Book::with('users')->get();

        return $books->map(function ($book){
            $startPages = data_get($book->users, '*.pivot.start_page');
            $endPages = data_get($book->users, '*.pivot.end_page');

            $minStartPage = !empty($startPages) ? min($startPages) :0;
            $maxEndPage = !empty($startPages) ? max($endPages) :0;

            return [
                'book_id' => $book->id,
                'book_name' => $book->name,
                'num_of_read_pages' => $maxEndPage !== 0 ? ($maxEndPage - $minStartPage) + 1 : 0
            ];
        })->filter(function ($books){
            return $books['num_of_read_pages'] > 0;
        })->sortByDesc('num_of_read_pages')->take(5);
    }
}
