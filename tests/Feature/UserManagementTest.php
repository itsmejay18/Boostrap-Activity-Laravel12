<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated users can view the user management page', function () {
    $admin = User::factory()->create();
    $listedUser = User::factory()->create([
        'name' => 'Listed User',
        'email' => 'listed@example.com',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.users.index'))
        ->assertOk()
        ->assertSee('User Management')
        ->assertSee($listedUser->email);
});

test('authenticated users can create a user', function () {
    $admin = User::factory()->create();

    $this->actingAs($admin)
        ->post(route('admin.users.store'), [
            'name' => 'New User',
            'email' => 'new-user@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ])
        ->assertRedirect(route('admin.users.index'));

    $this->assertDatabaseHas('users', [
        'name' => 'New User',
        'email' => 'new-user@example.com',
    ]);
});

test('authenticated users can update a user without changing the password', function () {
    $admin = User::factory()->create();
    $user = User::factory()->create([
        'password' => 'password123',
    ]);
    $originalPassword = $user->password;

    $this->actingAs($admin)
        ->put(route('admin.users.update', $user), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => '',
            'password_confirmation' => '',
        ])
        ->assertRedirect(route('admin.users.index'));

    expect($user->fresh()->name)->toBe('Updated Name')
        ->and($user->fresh()->email)->toBe('updated@example.com')
        ->and($user->fresh()->password)->toBe($originalPassword);
});

test('authenticated users can delete another user', function () {
    $admin = User::factory()->create();
    $user = User::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.users.destroy', $user))
        ->assertRedirect(route('admin.users.index'));

    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);
});

test('authenticated users cannot delete their own account from user management', function () {
    $admin = User::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.users.destroy', $admin))
        ->assertRedirect(route('admin.users.index'));

    $this->assertDatabaseHas('users', [
        'id' => $admin->id,
    ]);
});
