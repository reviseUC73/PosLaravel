<?php

// database/factories/PaymentFactory.php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'member_id' => \App\Models\Member::factory(),
            'sale_id' => \App\Models\Sale::factory(),
            'amount' => $this->faker->numberBetween(100, 1000),
            'paymentDate' => $this->faker->date(),
        ];
    }
}
