<?php

namespace Database\Factories;

use App\Models\Website;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $websites = Website::all('id')->pluck('id')->toArray();
        return [
            'title'       => $this->faker->title(),
            'description' => $this->faker->paragraph(),
            'website_id'  => array_rand($websites)
        ];
    }
}
