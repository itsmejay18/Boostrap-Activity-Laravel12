<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('users can log in and reach the dashboard', function () {
    $user = User::factory()->create([
        'name' => 'admin',
        'email' => 'admin@example.com',
        'password' => 'admin123',
    ]);

    $this->post(route('process_login'), [
        'email' => 'admin',
        'password' => 'admin123',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($user);

    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Dashboard');
});
