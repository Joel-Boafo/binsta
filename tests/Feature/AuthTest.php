<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

it('ensures the user can see the login page', function () {
    $response = $this->get(route('users.login'));
    $response->assertStatus(200);
});

it('ensures the user can login', function () {
    $user = User::factory()->create([
        'password' => bcrypt($password = 'i-love-laravel'),
    ]);

    $response = $this->post(route('users.login.post'), [
        'username' => $user->username,
        'password' => $password,
    ]);

    $response->assertStatus(302);
    $response->assertRedirect(route('home'));
    $response->assertSessionHas('status', 'Logged in successfully');

    Auth::logout();

    $user->delete();
});

it('ensures the user can see the register page', function () {
    $response = $this->get(route('users.register'));
    $response->assertStatus(200);
});

it('ensures the user can register', function () {
    $user = User::factory()->make();

    $response = $this->post(route('users.register.post'), [
        'username' => $user->username,
        'email' => $user->email,
        'password' => 'i-love-testing',
        'confirm_password' => 'i-love-testing'
    ]);

    $response->assertStatus(302);
    $response->assertRedirect(route('users.login'));
    $response->assertSessionHas('status', 'Registered successfully');

    Auth::logout();

    $user->delete();
});

it('tests for a failed login', function () {
    $user = User::factory()->create([
        'password' => 'i-love-testing',
    ]);

    $response = $this->post(route('users.login.post'), [
        'username' => $user->username,
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(302);
    $response->assertRedirect(route('users.login'));
    $response->assertSessionHas('error', 'Invalid credentials');

    Auth::logout();

    $user->delete();
});

it('ensures the user can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('users.logout'));

    $response->assertStatus(302);
    $response->assertRedirect(route('users.login'));
    $response->assertSessionHas('status', 'Logged out successfully');

    $user->delete();
});

it('tests for a failed registration attempt', function () {
    $user = User::factory()->make();

    $response = $this->post(route('users.register.post'), [
        'username' => $user->username,
        'email' => $user->email,
        'password' => 'i-love-laravel',
        'confirm_password' => 'wrong-password',
    ]);

    $response->assertStatus(302);
    $response->assertRedirect(route('home'));
    $response->assertSessionHasErrors();

    $user->delete();
});