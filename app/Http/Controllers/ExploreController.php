<?php

namespace App\Http\Controllers;

use App\Models\Analytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class ExploreController extends Controller
{
    public function index() //GET
    {
        $posts = Post::select('posts.*')
            ->with(['tags', 'contributors'])
            ->leftJoin('analytics', 'analytics.post_id', '=', 'posts.id')
            ->where('status', 'published')
            ->orderByDesc('analytics.views')
            ->get();

        $featured_post = $posts->first();

        return view('explore', compact('posts','featured_post'));
    }
}
