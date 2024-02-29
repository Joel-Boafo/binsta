<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use WithFaker;
    public function testUserCanSeeEditProfilePage()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile/edit');
        $response->assertStatus(200);
        $response->assertSee('Edit Profile');

        Auth::logout();
    }

    public function testUserCanUpdateProfile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/profile/lorenz', [
            'name' => $this->faker->name,
            'username' => $this->faker->userName,
            'email' => $this->faker->email,
            'bio' => $this->faker->sentence,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/profile/edit');

        $response->assertSessionHas('status', 'Profile updated successfully');
    }
}
