<?php

namespace Database\Factories;

use App\Models\Troc;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrocFactory extends Factory
{
    protected $model = Troc::class;

    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(['troc', 'echange', 'don']),
            'status' => 'active',
            'product_id' => null,
            'product_id_offered' => $this->faker->numberBetween(1, 100),
            'product_id_wanted' => $this->faker->numberBetween(1, 100)
        ];
    }
}
