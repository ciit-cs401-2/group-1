<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Enums\Status;
use App\Models\Analytics;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            TagSeeder::class,
        ]);

        foreach(Status::cases() as $case)
        {
            Post::factory(5)->create(['status' => $case])->each(function ($post) {
                Analytics::factory()->create([
                    'post_id' => $post->id,
                ]);
            });
        }
        
        User::factory(2)->create();

        $this->assignPostRelationships();
    }

    public function assignPostRelationships(): void
    {
        $users = User::pluck('id');
        $maxUserPerPost = min(3,User::count());
        $tags = Tag::all();
        $tagsCount = $tags->count();

        if ($users->isEmpty() || $tags->isEmpty()) return;

        foreach(Post::cursor() as $post)
        {
            $randomUsers = $users->random(rand(1, $maxUserPerPost));
            $randomTags = $tags->random(rand(1, max(1, floor($tagsCount / 2))));
            $post->tags()->syncWithoutDetaching($randomTags);
            $post->users()->syncWithoutDetaching($randomUsers);
            foreach($randomUsers as $i => $userId)
            {
                $role = $i === 0 ? '1' : '2';
                 $post->users()->syncWithoutDetaching([
                    $userId => ['Author_role' => $role]
                 ]);
            }
        }
    }
}
