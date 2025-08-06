<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {

        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->with('access_denied', 'You do not have permission.');
        }

        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => $user->id,
            'post_id' => $request->post_id,
            'content' => $request->content,
        ]);

        Post::find($request->post_id)->analytics->increment('comments');

        return redirect()->back()->with('success', 'Comment added.');
    }
}
