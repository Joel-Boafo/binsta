<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function placeComment(CommentRequest $request)
    {
        $request->validated();

        $post = Post::find($request->post_id);

        if ($post) {
            $post->comments()->create([
                'user_id' => auth()->user()->id,
                'comment' => $request->comment,
            ]);

            return redirect()->back();
        }

        return redirect()->route('home')->with('error', 'Post not found');
    }

    public function deleteComment(Request $request)
    {
        $post = Post::find($request->post_id);

        if ($post) {
            $comment = $post->comments()->where('id', $request->comment_id)->first();

            if ($comment && auth()->user()->id === $comment->user_id) {
                $comment->delete();
                return redirect()->back();
            }

            return redirect()->back()->with('error', 'Comment not found or you do not have permission to delete this comment');
        }

        return redirect()->back()->with('error', 'Post not found');
    }
}
