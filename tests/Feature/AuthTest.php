<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        // Step 5: Failed login
        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => 'invalid-password',
        ]);

        // Step 6: Asserts for failed login
        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    public function testRegisterPost(): void
    {
        // Use a database transaction to isolate each test
        DB::beginTransaction();

        // Step 1: Setup
        $user = User::factory()->make();

        // Step 2: Successful registration
        $response = $this->post('/register', [
            'username' => $user->username,
            'email' => $user->email,
            'password' => 'i-love-laravel',
            'confirm_password' => 'i-love-laravel',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHas('status');
        $this->assertGuest();

        // Rollback the transaction to remove the user from the database
        DB::rollBack();

        // Start a new transaction for the next test
        DB::beginTransaction();

        // Step 3: Failed registration
        $response = $this->post('/register', [
            'username' => $user->username,
            'email' => $user->email,
            'password' => 'i-love-laravel',
            'confirm_password' => 'invalid-password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/register');
        $response->assertSessionHas('error');
        $this->assertGuest();

        // Rollback the transaction to clean up the database
        DB::rollBack();
    }
}
