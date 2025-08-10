<?php

use App\Models\Book;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

it('allows a user to submit an interval on a book', function () {
    $this->actingAs(User::factory()->create());

    $book = Book::factory()->create();

    $response = $this->post(route('books.submit-interval'), [
        'book_id'    => $book->id,
        'start_page' => rand(10, 20),
        'end_page'   => rand(20, 30),
    ]);

    $response->assertStatus(200);
    expect($response->json('message'))
        ->toEqual(trans('message.interval-submitted-successfully'));
});

it('requires authentication to submit an interval on a book', function () {
    $book = Book::factory()->create();

    $response = $this->post(route('books.submit-interval'), [
        'book_id'    => $book->id,
        'start_page' => rand(10, 20),
        'end_page'   => rand(20, 30),
    ], [
        'accept' => 'application/json',
    ]);

    $response->assertStatus(Response::HTTP_UNAUTHORIZED);
});
