<?php

namespace Tests\Feature\Auth;

use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testUserCanLogin(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password')
        ]);
        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);


        $response->assertStatus(200)->assertJsonStructure([
            'message',
            'data' => [
                'token'
            ]
        ]);
    }

    public function testWillThrowExceptionIfCredentialsNotValid(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password')
        ]);
        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'abcs'
        ], [
            'accept' => 'application/json'
        ]);


        $this->assertEquals(trans('message.invalid_user'), $response->json()['message']);
    }
}
