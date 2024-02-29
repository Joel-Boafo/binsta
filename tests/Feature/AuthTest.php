<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testLogin(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function testRegister(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function testLoginPost(): void
    {
        // Step 1: Setup
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        // Step 2: Successful login
        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => $password,
        ]);

        // Step 3: Asserts for successful login
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);

        // Step 4: Logout the user
        Auth::logout();
    }

    public function testRegisterPost(): void
    {
        $user = User::factory()->make();

        $response = $this->post('/register', [
            'username' => $user->username,
            'email' => $user->email,
            'password' => 'i-love-laravel',
            'confirm_password' => 'i-love-laravel',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    public function testLoginPostFail()
    {
        $user = User::factory()->create([
            'password' => 'i-love-laravel',
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHas('error');
        $this->assertGuest();

        Auth::logout();
    }

    public function testregisterPostFail()
    {
        $user = User::factory()->make();

        $repsonse = $this->post('/register', [
            'username' => $user->username,
            'email' => $user->email,
            'password' => 'i-love-laravel',
            'confirm_password' => 'wrong-password',
        ]);

        $repsonse->assertStatus(302);
        $repsonse->assertRedirect('/register');
        $repsonse->assertSessionHas('error');
        $this->assertGuest();

        Auth::logout();
    }
}
