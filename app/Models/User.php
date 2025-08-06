<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Post;

/**
 * @method \Illuminate\Database\Eloquent\Relations\BelongsToMany contributedPosts()
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'email_verified_at',
        'registration_date',
        'last_login_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'registration_date' => 'datetime',
            'last_login_date' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function analytics() {
        return $this->contributedPosts->pluck('analytics')->filter();
    }

    public function getAnalyticsForAllAuthoredPosts() {
        return $this->posts()->with('analytics')->get()->pluck('analytics')->filter();
    }

    public function contributedPosts() {
        return $this->belongsToMany(Post::class, 'post_user_relationship', 'user_id', 'post_id')
                    ->withPivot('author_role');
    }

    public function mainPosts() {
        return $this->contributedPosts()->wherePivot('author_role', 'main-author');
    }
}
