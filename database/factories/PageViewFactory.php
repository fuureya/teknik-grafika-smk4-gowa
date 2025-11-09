<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PageView>
 */
class PageViewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paths = ['/', '/contact', '/visi-misi', '/kurikulum', '/struktur', '/produk', '/gallery', '/news', '/ecard'];

        return [
            'path' => $this->faker->randomElement($paths),
            'session_id' => $this->faker->uuid,
            'user_id' => null,
            'ip_address' => $this->faker->ipv4,
            'user_agent' => $this->faker->userAgent,
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'updated_at' => now(),
        ];
    }
}
