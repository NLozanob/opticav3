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
    public function definition(): array
    {
        return [
            'name'=> $this->faker -> word,
            'description' => $this ->faker->sentence,
            'stock_quantity' => $this ->faker->randomNumber(2),
            'purchase_price' => $this ->faker->randomNumber(2,0,1000),
            'registered_by' => \App\Models\User::factory(),
            'status' => "1",
            

        ];
    }
}
