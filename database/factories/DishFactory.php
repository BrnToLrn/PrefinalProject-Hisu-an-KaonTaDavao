<?php

namespace Database\Factories;

use App\Models\Dish;
use App\Models\Eatery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dish>
 */
class DishFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'eatery_id' => Eatery::factory(),
            'name' => fake()->randomElement([
                'Sinigang na Hipon',
                'Pork Sisig',
                'Grilled Tuna Belly',
                'Chicken Inasal',
                'Beef Bulalo Special',
                'Kinilaw na Bariles',
                'Crispy Pata',
                'Durian Shake Pure',
                'Sinuglaw Davao',
                'Pork Humba',
            ]),
            'price' => fake()->randomFloat(2, 45, 280),
            'is_bestseller' => fake()->boolean(35),
        ];
    }

    /**
     * Indicate that the dish is a bestseller.
     */
    public function bestseller(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_bestseller' => true,
        ]);
    }
}
