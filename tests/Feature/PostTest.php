<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

it('ensures the user can create a post', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->post(route('posts.create.post'), [
        'programming_language' => 'php',
        'code' => fake()->paragraph(),
        'caption' => fake()->sentence(),
    ]);

    $response->assertStatus(302);
    $response->assertRedirect(route('home'));
    $response->assertSessionHas('status', 'Post created successfully');

    Auth::logout();

    $user->posts()->delete();

    $user->delete();
});

it('ensures the user can edit a post', function () {
    $user = User::factory()->create();

    $post = $user->posts()->create([
        'programming_language' => 'php',
        'code' => fake()->paragraph(),
        'caption' => fake()->sentence(),
    ]);

    $response = $this->actingAs($user)->put(route('posts.update'), [
        'programming_language' => 'js',
        'code' => fake()->paragraph(),
        'caption' => fake()->sentence(),
        'post_id' => $post->id,
    ]);

    $response->assertStatus(302);
    $response->assertRedirect(route('home'));
    $response->assertSessionHas('status', 'Post updated successfully');

    Auth::logout();

    $user->posts()->delete();

    $user->delete();
});

it('ensures the user can like a post', function () {
    $user = User::factory()->create();

    $post = $user->posts()->create([
        'programming_language' => 'java',
        'code' => fake()->sentence(),
        'caption' => fake()->paragraph(),
    ]);

    $response = $this->actingAs($user)->post(route('posts.like'), [
        'post_id' => $post->id,
    ]);

    $response->assertStatus(302);
    $response->assertRedirect(route('home'));
    $response->assertSessionMissing('error');
});

it('ensures the user can unlike a post', function () {
    $user = User::factory()->create();

    $post = $user->posts()->create([
        'programming_language' => 'java',
        'code' => fake()->sentence(),
        'caption' => fake()->paragraph(),
    ]);

    $post->likes()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->post(route('posts.like'), [
        'post_id' => $post->id,
    ]);

    $response->assertStatus(302);
    $response->assertRedirect(route('home'));
    $response->assertSessionMissing('error');
});

it('ensures the user can comment on a post', function () {
    $user = User::factory()->create();

    $post = $user->posts()->create([
        'programming_language' => 'java',
        'code' => fake()->sentence(),
        'caption' => fake()->paragraph(),
    ]);

    $response = $this->actingAs($user)->post(route('posts.comment'), [
        'post_id' => $post->id,
        'comment' => fake()->sentence(),
    ]);

    $response->assertStatus(302);
    $response->assertRedirect(route('home'));
    $response->assertSessionMissing('error');
});

it('ensures the user can delete a comment', function () {
    $user = User::factory()->create();

    $post = $user->posts()->create([
        'programming_language' => 'java',
        'code' => fake()->sentence(),
        'caption' => fake()->paragraph(),
    ]);

    $comment = $post->comments()->create([
        'user_id' => $user->id,
        'comment' => fake()->sentence(),
    ]);

    $response = $this->actingAs($user)->delete(route('posts.comment.delete', $comment), [
        'post_id' => $post->id,
        'comment_id' => $comment->id,
    ]);

    $response->assertStatus(302);
    $response->assertRedirect(route('home'));
    $response->assertSessionMissing('error');

    Auth::logout();

    $user->posts()->delete();

    $user->delete();
});