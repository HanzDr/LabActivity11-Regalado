<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Post::where('is_published', true)
            ->get()
            ->each(function (Post $post) use ($users): void {
                for ($index = 0; $index < random_int(0, 5); $index++) {
                    Comment::factory()->create([
                        'post_id' => $post->id,
                        'user_id' => $users->random()->id,
                    ]);
                }
            });

        $pinnedPost = Post::where('is_pinned', true)->firstOrFail();
        $lola = User::where('email', 'lola.regalado@bulletin.test')->firstOrFail();

        Comment::factory()->create([
            'post_id' => $pinnedPost->id,
            'user_id' => $lola->id,
        ]);

        for ($index = 0; $index < 2; $index++) {
            Comment::factory()->create([
                'post_id' => $pinnedPost->id,
                'user_id' => $users->random()->id,
            ]);
        }
    }
}
