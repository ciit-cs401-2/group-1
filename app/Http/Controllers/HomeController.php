<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Models\Analytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $posts = Post::select('posts.*')
                ->leftJoin('analytics', 'analytics.post_id', '=', 'posts.id')
                ->with(['tags', 'contributors', 'analytics'])
                ->where('status', 'published')
                ->orderByDesc('analytics.views')
                ->take(3)
                ->get();

        return view('welcome', compact('posts'));
    }
}
