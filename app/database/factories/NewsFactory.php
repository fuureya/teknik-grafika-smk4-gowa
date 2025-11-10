<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cover_berita' => 'news/' . fake()->image('storage/app/public/news', 640, 480, null, false),
            'judul' => fake()->sentence(),
            'isi_berita' => fake()->paragraphs(5, true),
            'created_by' => User::inRandomOrder()->first()->id,
            'edited_by' => null,
        ];
    }
}
