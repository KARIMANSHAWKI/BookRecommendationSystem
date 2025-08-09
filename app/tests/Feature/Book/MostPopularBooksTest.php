<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\User;
use Tests\TestCase;

class MostPopularBooksTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testReturnMostPopularFiveBooks(): void
    {
        $bookOne = Book::factory()->create();
        $bookTwo = Book::factory()->create();

        $bookOne->users()->attach(User::factory()->create()->id, [
            'start_page' => 1,
            'end_page' => 50
        ]);

        $bookOne->users()->attach(User::factory()->create()->id, [
            'start_page' => 30,
            'end_page' => 60
        ]);

        $bookTwo->users()->attach(User::factory()->create()->id, [
            'start_page' => 1,
            'end_page' => 90
        ]);

        $bookTwo->users()->attach(User::factory()->create()->id, [
            'start_page' => 80,
            'end_page' => 120
        ]);

        $response = $this->get(route('books.get-recommended-books'));

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => [
                    'book_id', 'book_name', 'num_of_read_pages'
                ]
            ]
        ]);
        $this->assertTrue(head(data_get($response->json()['data'], '*.book_id')) == $bookTwo->id);
    }
}
