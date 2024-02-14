<?php

// database/factories/SaleLineItemFactory.php

namespace Database\Factories;

use App\Models\SaleLineItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleLineItemFactory extends Factory
{
    protected $model = SaleLineItem::class;

    public function definition()
    {
        return [
            'sale_id' => \App\Models\Sale::factory(),
            'item_id' => \App\Models\Item::factory(),
            'quantity' => $this->faker->numberBetween(1, 5),
        ];
    }
}
