<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use App\Models\Sale_detail;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale_detail>
 */
class Sale_detailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $saleIds = DB::table('customers')->pluck('id')->toArray();
        // $productIds = DB::table('products')->pluck('id')->toArray();
        return [
            'quantity' => $this->faker->numberBetween(1, 10),
            'subtotal' => $this->faker->randomFloat(2, 10, 500),
            'sale_id' => \App\Models\Sale::factory(),
            'product_id' => \App\Models\Product::factory(),
            
        ];
    }
}
