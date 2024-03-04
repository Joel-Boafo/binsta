<?php

namespace Tests\Feature;

use App\Models\User;
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
            'caption' => $this->faker->sentence(),
            'code' => $this->faker->paragraph(),
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $response->assertSessionHas('status', 'Post created successfully');
    }

    public function testUserCanEditPost()
    {
        $user = User::factory()->create();
        $post = $user->posts()->create([
            'programming_language' => 'php',
            'caption' => $this->faker->sentence(),
            'code' => $this->faker->paragraph(),
        ]);

        $response = $this->actingAs($user)->put(route('posts.update'), [
            'post_id' => $post->id,
            'programming_language' => 'js',
            'caption' => $this->faker->sentence(),
            'code' => $this->faker->paragraph(),
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $response->assertSessionHas('status', 'Post updated successfully');
    }

    public function testUserCanDeletePost()
    {
        $user = User::factory()->create();

        $post = $user->posts()->create([
            'programming_language' => 'java',
            'caption' => $this->faker->sentence(),
            'code' => $this->faker->paragraph(),
        ]);

        $response = $this->actingAs($user)->delete(route('posts.delete', $post), [
            'post_id' => $post->id,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $response->assertSessionMissing('error');
    }

    public function testUserCanLikePost()
    {
        $user = User::factory()->create();

        $post = $user->posts()->create([
            'programming_language' => 'java',
            'caption' => $this->faker->sentence(),
            'code' => $this->faker->paragraph(),
        ]);

        $response = $this->actingAs($user)->post(route('posts.like'), [
            'post_id' => $post->id,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $response->assertSessionMissing('error');
    }

    public function testUserCanUnlikePost()
    {
        $user = User::factory()->create();

        $post = $user->posts()->create([
            'programming_language' => 'java',
            'caption' => $this->faker->sentence(),
            'code' => $this->faker->paragraph(),
        ]);

        $post->likes()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post(route('posts.like'), [
            'post_id' => $post->id,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $response->assertSessionMissing('error');
    }

    public function testUserCanCommentOnPost()
    {
        $user = User::factory()->create();

        $post = $user->posts()->create([
            'programming_language' => 'java',
            'caption' => $this->faker->sentence(),
            'code' => $this->faker->paragraph(),
        ]);

        $response = $this->actingAs($user)->post(route('posts.comment'), [
            'post_id' => $post->id,
            'comment' => $this->faker->sentence(),
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $response->assertSessionMissing('error');
    }

    public function testUserCanDeleteComment()
    {
        $user = User::factory()->create();

        $post = $user->posts()->create([
            'programming_language' => 'java',
            'caption' => $this->faker->sentence(),
            'code' => $this->faker->paragraph(),
        ]);

        $comment = $post->comments()->create([
            'user_id' => $user->id,
            'comment' => $this->faker->sentence(),
        ]);

        $response = $this->actingAs($user)->delete(route('posts.comment.delete', $comment), [
            'post_id' => $post->id,
            'comment_id' => $comment->id,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $response->assertSessionMissing('error');
    }
}
