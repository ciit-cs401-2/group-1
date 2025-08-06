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
        $post = Post::with(['tags', 'contributors', 'analytics'])->findOrFail($id);

        $otherPosts = Post::where('id', '!=', $id)->take(4)->get();
        
        return view('article', compact('post'));
    }
}
