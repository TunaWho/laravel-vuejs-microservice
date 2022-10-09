<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'order_id'      => rand(1, 10),
            'product_title' => fake()->text(30),
            'price'         => fake()->numberBetween(10, 100),
            'quantity'      => fake()->numberBetween(1, 5),
        ];
    }
}
