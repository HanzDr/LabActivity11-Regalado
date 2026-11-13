<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            'Purok Regalado',
            'Urgent',
            'Announcement',
            'Community Events',
            'Health',
        ] as $name) {
            Tag::create(['name' => $name]);
        }

        $tags = Tag::all();
        $pinnedPost = Post::where('is_pinned', true)->firstOrFail();

        Post::whereKeyNot($pinnedPost->getKey())
            ->get()
            ->each(function (Post $post) use ($tags): void {
                $post->tags()->attach(
                    $tags->random(random_int(1, 3))->modelKeys()
                );
            });

        $pinnedPost->tags()->sync([
            Tag::where('name', 'Purok Regalado')->value('id'),
            Tag::where('name', 'Urgent')->value('id'),
        ]);
    }
}
