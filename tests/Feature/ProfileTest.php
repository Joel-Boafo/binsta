<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

it('ensures the user can see the edit profile page', function () {
    $response = $this->get(route('profiles.edit'));
    $response->assertStatus(302);
});

it('ensures the user can edit their profile', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->put(route('profiles.lorenz'), [
        'name' => fake()->name(),
        'username' => fake()->userName(),
        'email' => fake()->safeEmail(),
        'bio' => fake()->paragraph(),
    ]);

    $response->assertStatus(302);
    $response->assertRedirect(route('profiles.edit'));
    $response->assertSessionHas('status', 'Profile updated successfully');

    Auth::logout();

    $user->delete();
});

it('ensures the user can change their password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->put(route('profiles.update-password'), [
        'current_password' => $user->password,
        'password' => 'i-love-testing',
        'confirm_password' => 'i-love-testing',
    ]);

    $response->assertStatus(302);
    $response->assertRedirect(route('users.login'));
    $response->assertSessionHas('status', 'Password updated successfully');

    Auth::logout();

    $user->delete();
});

it('ensures the user can see the profile show page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('profiles.show', $user->username));

    $response->assertStatus(200);

    Auth::logout();

    $user->delete();
});
