<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array

    
    {
        // $customerIds = DB::table('customers')->pluck('id')->toArray();
        return [
            'sale_date' => $this->faker->dateTime(),
            'total_sale' => $this->faker->randomFloat(2, 10, 500), 
            'customer_id' => \App\Models\Customer::factory(),
            'registered_by' => \App\Models\User::factory(),
            'status' => "1",
        ];
    }
}
