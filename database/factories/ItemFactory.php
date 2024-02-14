<?php

// database/factories/ItemFactory.php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->numberBetween(10, 100),
            'description' => $this->faker->sentence,
            'type' => $this->faker->word,
        ];
    }
}
