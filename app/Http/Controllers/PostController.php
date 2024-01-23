<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Post $post)
    {
        $likes = $post->likes()->pluck('user_id')->toArray();
        $comments = $post->comments()->orderBy('created_at', 'desc')->get();

        return view('posts.show', compact('post', 'likes', 'comments'));
    }

    public function feed()
    {
        $posts = Post::with(['user', 'comments', 'likes'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('welcome', compact('posts'));
    }

    public function create()
    {
        $user = auth()->user();
        return view('posts.create', compact('user'));
    }

    public function createPost(PostRequest $request)
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

    public function edit(Request $request)
    {
        $user = auth()->user();
        $post = Post::find($request->post_id);

        if (!$post) {
            return redirect()->route('home')->with('error', 'Post not found');
        }

        return view('posts.edit', compact('user', 'post'));
    }

    public function updatePost(Request $request)
    {
        $post = Post::find(request()->post_id);

        if (!$post) {
            return redirect()->route('home')->with('error', 'Post not found');
        }

        $post->update([
            'caption' => $request->caption,
            'code' => $request->code,
            'programming_language' => $request->programming_language,
        ]);

        return redirect()->route('home')->with('status', 'Post updated successfully');
    }

    public function likePost(Request $request)
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

    public function deletePost(PostRequest $request, Post $post)
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
