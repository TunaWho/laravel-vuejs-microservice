<?php

namespace Database\Factories;

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
    public function definition()
    {
        return [
            'title'       => fake()->text(30),
            'image'       => fake()->imageUrl(360, 360, 'animals', true, 'cats'),
            'description' => fake()->text,
            'price'       => fake()->numberBetween(10, 100),
        ];
    }
}
