<?php

namespace App\Http\Controllers;

use App\Models\Analytics;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function store(Request $request)
    {
        Log::info('store method hit');

        // Normalize JSON string inputs (for contributors and tags)
        $request->merge([
            'contributors' => is_string($request->input('contributors'))
                ? json_decode($request->input('contributors'), true) ?? []
                : $request->input('contributors'),

            'tags' => is_string($request->input('tags'))
                ? json_decode($request->input('tags'), true) ?? []
                : $request->input('tags'),
        ]);

        // Validate request inputs
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'contributors' => 'nullable|array',
            'tags' => 'nullable|array',
            'image' => 'nullable|image|max:2048',
        ]);

        Log::info('Saving post...');

        // Handle image upload
        $imageData = null;
        if ($request->hasFile('image')) {
            $imageData = file_get_contents($request->file('image')->getRealPath());
        }

        // Determine status and publication date
        $status = $request->input('status', 'draft');
        $publishedDate = $status === 'published' ? now() : null;

        // Create the post
        $post = Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image_data' => $imageData,
            'status' => $status,
            'published_date' => $publishedDate,
        ]);

        if (!$post->exists) {
            Log::error('Post failed to save.');
            return redirect()->back()->with('error', 'Failed to create post.');
        }

        Log::info('Post created with ID: ' . $post->id);

        /**
         * Handle Shared Authorship
         */
        $submittedContributorIds = $request->input('contributors', []);
        $validContributorIds = [];
        $invalidContributorIds = [];

        foreach ($submittedContributorIds as $userId) {
            if (User::where('id', $userId)->exists()) {
                $validContributorIds[] = $userId;
            } else {
                $invalidContributorIds[] = $userId;
            }
        }

        // Force status to draft if any invalid contributor ID was found
        if (!empty($invalidContributorIds)) {
            $post->update([
                'status' => 'draft',
                'published_date' => null,
            ]);
            Log::warning('Invalid contributor IDs found: ', $invalidContributorIds);
        }

        Log::info('Raw contributors input:', $request->input('contributors'));
        Log::info('Valid contributor IDs:', $validContributorIds);
        Log::info('Current authenticated user ID: ' . auth()->id());

        // Prepare the pivot sync array for main & co-authors
        $authorData = [
            auth()->id() => ['author_role' => 'main-author'],
        ];

        foreach ($validContributorIds as $userId) {
            if ($userId != auth()->id()) {
                $authorData[$userId] = ['author_role' => 'co-author'];
            }
        }

        $post->contributors()->sync($authorData);
        Log::info('Author data synced to pivot table:', $authorData);

        /**
         * Handle Tags
         */
        $tagIds = [];
        foreach ($request->input('tags', []) as $tagName) {
            $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
            $tagIds[] = $tag->id;
        }

        $post->tags()->sync($tagIds);

        return redirect('/newdashboard')->with('success', 'Post created successfully!');
    }

    public function drafts() {
        $drafts = Post::where('status', 'draft')->latest()->get();
        return view('posts.drafts', compact('drafts'));
    }

    public function showImage($id) {
        $post = Post::findOrFail($id);

        if (!$post->image_data) {
            abort(404);
        }

        return response($post->image_data)->header('Content-Type', 'image/jpeg');
    }

    /*public function show($id) {
        $post = Post::with(['contributors', 'tags', 'analytics'])->findOrFail($id);

        // Increment view count using the existing analytics relation 
        if ($post->analytics) {
            $post->analytics->increment('views');
        } else {
            // If there's no analytics record yet, create one
            $post->analytics()->create([
                'views' => 1,
                'likes' => 0,
                'comments' => 0
            ]);
        }

        $otherPosts = Post::where('id', '!=', $id)->latest()->take(4)->get();

        return view('article', compact('post', 'otherPosts'));
    }*/

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            abort(404, 'Post not found.');
        }

        $post->tags()->detach();
        $post->users()->detach();
        $post->analytics()->delete();
        $post->delete();

        return redirect('/newdashboard')->with('status', 'Post deleted successfully.');
    }

    public function editDraft($id)
    {
        $post = Post::with(['tags', 'contributors'])->where('status', 'draft')->findOrFail($id);

        return view('newdashboard', [
            'editingDraft' => true,
            'post' => $post
        ]);
    }
}
