<?php

namespace App\Domain\Services\Classes;

use App\Domain\DTOs\BookIntervalDTO;
use App\Domain\Repositories\Interfaces\IBookRepository;
use App\Domain\Services\Interfaces\IBookService;
use App\Events\BookSectionAssigned;
use App\Jobs\NotifyUserAfterSubmitIntervalOnBookJob;
use App\Models\Book;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class BookService extends AbstractService implements IBookService
{
    public function __construct()
    {
        parent::__construct(resolve(IBookRepository::class));
    }

    public function submitUserReadingInterval(BookIntervalDTO $data): \Illuminate\Foundation\Application|array|string|Translator|Application|null
    {
        $book = $this->repository->find($data->book_id);
        $book->users()->attach(auth()->id(), [
            'start_page' => $data->start_page,
            'end_page' => $data->end_page,
        ]);
        NotifyUserAfterSubmitIntervalOnBookJob::dispatch(auth()->user(), $book->name, $data->start_page, $data->end_page);

        return trans('message.interval-submitted-successfully');
    }

    public function getMostRecommendedFiveBooks()
    {
        $books = $this->repository->all(relations: ['users']);
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

    public function assignBookToSection(array $data, Book $book): void
    {
        $book->section()->associate(Arr::get($data, 'section_id'));
        $book->save();
        event(new BookSectionAssigned($book, auth()->user()));
    }

    public function searchInGoogleBooks(): array
    {
        $query = request('search_key');
        $response = Http::get(Config::get('search_integration.google_books_url'), [
            'q' => request('search_key') ? $query : null,
        ]);

        return $this->parseResponse($response->json());

    }

    private function parseResponse(array $response): array
    {
        if (data_get($response, 'totalItems') > 0){
            $books = data_get($response, 'items');
            $parsedBooks = Arr::map($books, function ($book){
                return [
                    'title' => data_get($book, 'volumeInfo.title'),
                    'author' => data_get($book, 'volumeInfo.publisher'),
                    'pageCount' => data_get($book, 'volumeInfo.pageCount'),
                    'images' => data_get($book, 'volumeInfo.imageLinks'),
                    'book_url' => data_get($book, 'accessInfo.webReaderLink'),
                ];
            });
        }else {
            $parsedBooks = [];
        }

        return $parsedBooks;
    }
}
