<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PostTest extends TestCase
{
    use WithFaker;

    public function testUserCanSeeHomePage()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);

        Auth::logout();
    }

    public function testUserCanCreateNewPost()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('posts.create.post'), [
            'programming_language' => 'php',
            'caption' => '🔥',
            'code' => $this->faker->sentence,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
        
        $response->assertSessionHas('status', 'Post created successfully');
    }

    public function testUserCanEditPost()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('posts.update'), [
            'programming_language' => 'js',
            'caption' => $this->faker->sentence,
            'code' => $this->faker->paragraph,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $response->assertSessionHas('status', 'Post updated successfully');
    }
}
