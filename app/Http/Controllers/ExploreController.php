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
        $posts = Post::with(['tags', 'contributors'])
            ->withSum('analytics as total_views', 'views')
            ->where('status', 'published')
            ->orderByDesc('published_date')
            ->get();

        $featured_post = $posts->first();

        return view('explore', compact('posts','featured_post'));
    }
}
