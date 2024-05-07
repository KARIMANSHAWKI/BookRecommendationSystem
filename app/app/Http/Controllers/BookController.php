<?php

namespace App\Http\Controllers;

use App\Domain\Services\Interfaces\IBookService;
use App\Http\Requests\BookIntervalSubmitRequest;
use App\Http\Resources\MostRecommendedBooksResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{

    public function __construct(
        private readonly IBookService $bookService
    )
    {
    }

    public function submitUserReadingInterval(BookIntervalSubmitRequest $request): JsonResponse
    {
        return apiResponse(message: $this->bookService->submitUserReadingInterval($request->validated()));

    }

    public function getMostRecommendedFiveBooks(): AnonymousResourceCollection
    {
        return MostRecommendedBooksResource::collection($this->bookService->getMostRecommendedFiveBooks());
    }
}
