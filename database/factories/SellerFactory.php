<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seller>
 */
class SellerFactory extends Factory
{
    
    public function definition(): array
    {
        return [
            'seller_name' => $this->faker->unique()->name(),
            'seller_document' => $this->faker->unique()->numberBetween(1801195500000, 1801200099999),
            'seller_phone' => $this->faker->unique()->numberBetween(80000000, 99999999),
        ];
    }
}
