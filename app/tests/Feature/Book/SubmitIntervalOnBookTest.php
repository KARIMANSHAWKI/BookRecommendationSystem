<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SubmitIntervalOnBookTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testUserCanSubmitIntervalOnBook(): void
    {
        $this->actingAs(User::factory()->create());

        $book = Book::factory()->create();
        $response = $this->post(route('books.submit-interval'), [
            'book_id' => $book->id,
            'start_page' => rand(10, 20),
            'end_page' => rand(20, 30)
        ]);

        $response->assertStatus(200);
        $this->assertEquals(trans('message.interval-submitted-successfully'), $response->json()['message']);
    }

    public function testUserWhoSubmitIntervalMustBeAuth()
    {
        $book = Book::factory()->create();
        $response = $this->post(route('books.submit-interval'), [
            'book_id' => $book->id,
            'start_page' => rand(10, 20),
            'end_page' => rand(20, 30)
        ], [
            'accept' => 'application/json'
        ]);


        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
