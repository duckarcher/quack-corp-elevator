<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Elevator>
 */
class ElevatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'floor' => fake()->numberBetween(-3, 7),
        ];
    }

    public function inFloor($floor): Factory
    {
        return $this->state(function (array $attributes) use ($floor) {
            return [
                'floor' => $floor,
            ];
        });
    }
}
