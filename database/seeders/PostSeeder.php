<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = File::get('database/json/posts.json');
        $posts = json_decode($jsonData);

        foreach($posts as $post)
        {
            Post::create(
                [
                    'title'=>$post->title,
                    'description'=>$post->description,
                    'user_id'=>$post->user_id
                ]
            );
        }
    }
}
