<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request) 
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $sortFieldInput = 'updated_at'; // Default values in case
        $sortOrder = 'desc';

        
        $posts = $user->contributedPosts()->latest()->get();
        $drafts = $posts->where('status', 'draft');

        $analytics = $posts->reduce(function ($carry, $post) {
            $carry['likes'] += $post->analytics->likes ?? 0;
            $carry['comments'] += $post->analytics->comments ?? 0;
            $carry['views'] += $post->analytics->views ?? 0;
            return $carry;
        }, ['likes' => 0, 'comments' => 0, 'views' => 0]);

        return view('newdashboard', compact('posts', 'analytics', 'drafts', 'sortFieldInput', 'sortOrder'));
    }

    public function sortPosts(Request $request) {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $sortFieldInput = $request->input('sortOptions', 'updated_at');
        $sortOrder = $request->input('sortOrder', 'desc');

        $validSortFields = [
            'title' => 'title',
            'date' => 'updated_at',
            'published_date' => 'published_date'
        ];

        $sortField = $validSortFields[$sortFieldInput] ?? 'updated_at';

        $posts = $user->contributedPosts()->orderBy($sortField, $sortOrder)->get();
        $drafts = $posts->where('status', 'draft');

        $analytics = $posts->reduce(function ($carry, $post) {
            $carry['likes'] += $post->analytics->likes ?? 0;
            $carry['comments'] += $post->analytics->comments ?? 0;
            $carry['views'] += $post->analytics->views ?? 0;
            return $carry;
        }, ['likes' => 0, 'comments' => 0, 'views' => 0]);

        return view('newdashboard', compact('posts', 'analytics', 'drafts', 'sortFieldInput', 'sortOrder'));
    }
} 
