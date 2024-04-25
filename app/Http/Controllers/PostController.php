<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Post $post): View
    {
        $likes = $post->likes()->pluck('user_id')->toArray();
        $comments = $post->comments()->orderBy('created_at', 'desc')->get();

        return view('posts.show', compact('post', 'likes', 'comments'));
    }

    public function feed(): View
    {
        $posts = Post::with(['user', 'comments', 'likes'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('welcome', compact('posts'));
    }

    public function create(): View
    {
        $user = auth()->user();
        return view('posts.create', compact('user'));
    }

    public function createPost(PostRequest $request): RedirectResponse
    {
        $request->validated();

        $user = User::find(auth()->user()->id);

        $user->posts()->create([
            'caption' => $request->caption,
            'code' => $request->code,
            'programming_language' => $request->programming_language,
        ]);

        return redirect()->route('home')->with('status', 'Post created successfully');
    }

    public function edit(Request $request): void
    {
        $user = auth()->user();
        $post = Post::find($request->post_id);

        !$post ? redirect()->route('home')->with('error', 'Post not found') : view('posts.edit', compact('user', 'post'));
    }

    public function updatePost(Request $request): RedirectResponse
    {
        $post = Post::find(request()->post_id);

        !$post ? redirect()->route('home')->with('error', 'Post not found') : null;

        $post->update([
            'caption' => $request->caption,
            'code' => $request->code,
            'programming_language' => $request->programming_language,
        ]);

        return redirect()->route('home')->with('status', 'Post updated successfully');
    }

    public function likePost(Request $request): RedirectResponse
    {
        $post = Post::find($request->post_id);

        if ($post) {
            $like = $post->likes()->where('user_id', auth()->user()->id)->first();

            if ($like) {
                $like->delete();
            } else {
                $post->likes()->create(['user_id' => auth()->user()->id]);
            }

            return redirect()->back();
        }

        return redirect()->back()->with('error', 'Post not found');
    }

    public function deletePost(Request $request, Post $post): RedirectResponse
    {
        $post = Post::find($request->post_id);

        if ($post && auth()->user()->id === $post->user_id) {
            $post->likes()->delete();
            $post->comments()->delete();
            $post->delete();
            return redirect()->route('home');
        }

        return redirect()->route('home')->with('error', 'Post not found');
    }
}
