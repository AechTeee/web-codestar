<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            'user_id' => 1,
            'title' => "Bai viet so 1",
            'slug' => 'Bai-viet-so-1',
            'content' => "huong dan seeder trong lop php",
            'created_at' => now(),
            'update_at' => now()
        ]);
    }
}
