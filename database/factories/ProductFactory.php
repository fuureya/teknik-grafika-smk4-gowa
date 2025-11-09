<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cover_product' => 'products/' . fake()->image('storage/app/public/products', 640, 480, null, false),
            'namaproduct' => fake()->words(3, true),
            'deskripsi_singkat' => fake()->sentence(),
            'harga' => fake()->randomFloat(2, 10000, 1000000),
            'full_deskripsi' => fake()->paragraphs(3, true),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            ProductImage::factory(3)->create([
                'product_id' => $product->id,
            ]);
        });
    }
}
