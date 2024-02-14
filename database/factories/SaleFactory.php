<?php

// database/factories/SaleFactory.php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition()
    {
        return [
            'member_id' => \App\Models\Member::factory(),
            'status' => 'completed',
            'totalPrice' => $this->faker->numberBetween(100, 1000),
        ];
    }
}
