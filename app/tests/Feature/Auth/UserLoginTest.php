<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use function Pest\Laravel\post;

uses(TestCase::class);
it('allows a user to login', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password')
    ]);

    $response = post(route('auth.login'), [
        'email' => $user->email,
        'password' => 'password'
    ]);

    $response
        ->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'data' => [
                'token'
            ]
        ]);
});

it('throws an exception if credentials are not valid', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password')
    ]);

    $response = post(route('auth.login'), [
        'email' => $user->email,
        'password' => 'abcs'
    ], [
        'accept' => 'application/json'
    ]);

    expect($response->json('message'))
        ->toEqual(trans('message.invalid_user'));
});
