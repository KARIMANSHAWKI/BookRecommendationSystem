<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;
use function Pest\Laravel\get;

uses(TestCase::class);
it('allows a user to search in google books', function () {

    // Fake the HTTP request
    Http::fake([
        Config::get('search_integration.google_books_url') . '*' => Http::response(getFileContent('mock/search/response_200.json'), 200)
    ]);

    $response = get(route('books.google.search', ['search_key' => Str::random(5)]));

    expect($response->status())->toBe(200)
        ->and($response->json())
        ->and($response->json('data.0'))
        ->toHaveKeys(['title', 'author', 'pageCount', 'book_url', 'images']);

});

it('test search empty response', function () {

    // Fake the HTTP request
    Http::fake([
        Config::get('search_integration.google_books_url') . '*' => Http::response(getFileContent('mock/search/empty_response.json'), 200)
    ]);

    $response = get(route('books.google.search', ['search_key' => Str::random(5)]));

    expect($response->status())->toBe(200)
        ->and($response->json())
        ->and($response->json('data.0'))
        ->toBeEmpty();

});


