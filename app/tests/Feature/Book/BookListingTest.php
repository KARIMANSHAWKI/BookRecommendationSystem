<?php

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

beforeEach(function () {
    Event::fake([\App\Events\BookCreated::class]);
    Permission::findOrCreate('view books', 'web');
});

function authenticateBookReader(): void
{
    $user = User::factory()->create();
    $user->givePermissionTo('view books');
    Sanctum::actingAs($user);
}

it('searches and paginates books with stable ordering', function () {
    authenticateBookReader();

    $first = Book::factory()->create(['name' => 'Laravel Basics', 'description' => 'PHP']);
    $second = Book::factory()->create(['name' => 'Advanced Laravel', 'description' => 'PHP']);
    Book::factory()->create(['name' => 'Python', 'description' => 'Python']);

    $this->getJson('/api/v1/books?search=Laravel&per_page=1&page=1')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.id', $first->id)
        ->assertJsonPath('meta.total', 2)
        ->assertJsonPath('meta.per_page', 1);

    $this->getJson('/api/v1/books?search=Laravel&per_page=1&page=2')
        ->assertOk()
        ->assertJsonPath('data.0.id', $second->id);
});

it('rejects unauthenticated requests', function () {
    $this->getJson('/api/v1/books')->assertUnauthorized();
});

it('rejects users without permission', function () {
    Sanctum::actingAs(User::factory()->create());
    $this->getJson('/api/v1/books')->assertForbidden();
});

it('rejects invalid listing parameters', function () {
    authenticateBookReader();

    $this->getJson('/api/v1/books?per_page=101&page=0&search[]=invalid')
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['per_page', 'page', 'search']);
});
