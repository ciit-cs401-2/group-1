<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image_data',
        //'image_path',
        'published_date',
        'status',
    ];

    protected $casts = [
        'published_date' => 'datetime',
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'post_user_relationship')
                    ->withPivot('author_role');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'post_tag_relationship');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function analytics() {
        return $this->hasOne(Analytics::class);
    }

    public function contributedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_user_relationship', 'user_id', 'post_id')
            ->withPivot('author_role');
    }

    public function contributors()
    {
        return $this->belongsToMany(User::class, 'post_user_relationship', 'post_id', 'user_id')
                    ->withPivot('author_role');
    }
}
