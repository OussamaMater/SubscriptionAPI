<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Website;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Website::factory(10)->create();
        User::factory(10)->create();
        Post::factory(10)->create();
    }
}
