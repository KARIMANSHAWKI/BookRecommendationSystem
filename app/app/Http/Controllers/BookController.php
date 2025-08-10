<?php

namespace App\Http\Controllers;

use App\Domain\DTOs\BookDTO;
use App\Domain\DTOs\BookIntervalDTO;
use App\Domain\Services\Interfaces\IBookService;
use App\Http\Requests\AssignBookSectionRequest;
use App\Http\Requests\BookIntervalSubmitRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\GoogleBooksResource;
use App\Http\Resources\MostRecommendedBooksResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{
    public function __construct(
        private readonly IBookService $bookService
    )
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $books = $this->bookService->list(request('per_page', 15));

        return BookResource::collection($books)
            ->additional([
                'meta' => [
                    'current_page' => $books->currentPage(),
                    'last_page' => $books->lastPage(),
                    'total' => $books->total(),
                ]
            ]);
    }

    public function show(int $bookId): BookResource
    {
        $book = $this->bookService->get($bookId);

        return BookResource::make($book);
    }

    public function store(BookStoreRequest $request): JsonResponse
    {
        $requestData = (array)BookDTO::fromRequest($request->validated());
        $this->bookService->create($requestData);

        return apiResponse(message: trans('message.created'));
    }

    public function update(BookUpdateRequest $request, int $bookId): BookResource
    {
        $requestData = array_filter((array)BookDTO::fromRequest($request->validated()));
        $this->bookService->update($bookId, $requestData);

        return BookResource::make();
    }

    public function destroy($bookId): JsonResponse
    {
        $this->authorize('delete books');

        $this->bookService->delete($bookId);

        return apiResponse(message: trans('message.deleted'));
    }

    public function assignSection(AssignBookSectionRequest $request, Book $book): JsonResponse
    {
        $this->bookService->assignBookToSection($request->validated(), $book);

        return apiResponse(message: trans('message.assigned'));
    }

    public function submitUserReadingInterval(BookIntervalSubmitRequest $request): JsonResponse
    {
        $requestData = BookIntervalDTO::fromRequest($request->validated());
        $message = $this->bookService->submitUserReadingInterval($requestData);

        return apiResponse(message: $message);

    }

    public function getMostRecommendedFiveBooks(): AnonymousResourceCollection
    {
        $books = $this->bookService->getMostRecommendedFiveBooks();

        return MostRecommendedBooksResource::collection($books);
    }

    public function searchInGoogleBooks(): AnonymousResourceCollection
    {
        $books = $this->bookService->searchInGoogleBooks();

        return GoogleBooksResource::collection($books);
    }
}
