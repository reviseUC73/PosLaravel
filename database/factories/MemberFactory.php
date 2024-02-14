<?php

// database/factories/MemberFactory.php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'type' => 'regular', // Example type
            'location' => $this->faker->address,
            'balance' => $this->faker->numberBetween(1000, 5000),
        ];
    }
}
