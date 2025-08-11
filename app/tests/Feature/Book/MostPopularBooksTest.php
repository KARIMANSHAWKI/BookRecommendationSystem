<?php

use App\Models\Book;
use App\Models\User;
use Tests\TestCase;
use function Pest\Laravel\get;

uses(TestCase::class);

it('returns the most popular five books', function () {
    $bookOne = Book::factory()->create();
    $bookTwo = Book::factory()->create();

    $bookOne->users()->attach(User::factory()->create()->id, [
        'start_page' => 1,
        'end_page' => 50,
    ]);

    $bookOne->users()->attach(User::factory()->create()->id, [
        'start_page' => 30,
        'end_page' => 60,
    ]);

    $bookTwo->users()->attach(User::factory()->create()->id, [
        'start_page' => 1,
        'end_page' => 90,
    ]);

    $bookTwo->users()->attach(User::factory()->create()->id, [
        'start_page' => 80,
        'end_page' => 120,
    ]);

    $response = get(route('books.get-recommended-books'));

    $response
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'book_id',
                    'book_name',
                    'num_of_read_pages',
                ],
            ],
        ]);

    expect(head(data_get($response->json(), 'data.*.book_id')))
        ->toBe($bookTwo->id);
});
