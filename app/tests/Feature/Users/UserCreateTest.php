<?php

namespace Tests\Feature\Users;

use App\Models\User;
const ROUTE_NAME = 'users.store';

it('can create user', function () {
    $userData = User::factory()->raw();
    $authUser = User::factory()->create();
    $response = $this->actingAs($authUser)->postJson(route(ROUTE_NAME), $userData);
    $response->assertStatus(200);
});
