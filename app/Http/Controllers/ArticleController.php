<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class ArticleController extends Controller
{
    public function index() //GET
    {
        return view('article');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()    //GET
    {
        return view('article.create');
    }

    public function show($id) {
        $post = Post::with(['tags', 'contributors', 'analytics'])
            ->whereIn('status', ['published', 'archived'])
            ->findOrFail($id);

        $post->content = trim($post->content);

        // Increment view count
        if ($post->analytics) {
            $post->analytics->increment('views');
        } else {
            $post->analytics()->create([
                'views' => 1,
                'likes' => 0,
                'comments' => 0
            ]);
        }

        $otherPosts = Post::where('id', '!=', $id)
            ->where('status', 'published')
            ->latest()
            ->take(4)
            ->get();

        return view('article', compact('post', 'otherPosts'));
    }

    public function explore(Request $request)
    {
        $query = $request->input('query');

        $posts = Post::with(['tags', 'contributors', 'analytics'])
            ->when($query, function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                ->orWhere('content', 'like', "%{$query}%");
            })
            ->latest()
            ->get();

        // Select featured post based on highest view-to-like ratio
        $featured_post = $posts->filter(function ($post) {
            $likes = $post->analytics->likes ?? 0;
            return $likes > 0; // Avoid division by zero
        })->sortByDesc(function ($post) {
            $likes = $post->analytics->likes;
            $views = $post->analytics->views;

            return $views / max($likes, 1); // Prevent divide-by-zero
        })->first();

        // Fallback in case all posts have 0 likes
        if (!$featured_post && $posts->isNotEmpty()) {
            $featured_post = $posts->first();
        }

        return view('explore', compact('posts', 'featured_post'));
    }

}