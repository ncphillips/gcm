<?php

namespace Database\Factories;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    public function definition(): array
    {
        return [
            'reference' => '',
            'description' => $this->faker->word,
            'notes' => '',
            'tech_level' => $this->faker->numberBetween(1, 6),
            'value' => $this->faker->randomFloat(0, 0, 1000),
            'weight' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
