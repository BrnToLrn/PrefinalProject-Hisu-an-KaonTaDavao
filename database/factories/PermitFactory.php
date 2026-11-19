<?php

namespace Database\Factories;

use App\Models\Eatery;
use App\Models\Permit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Permit>
 */
class PermitFactory extends Factory
{
    /**
     * Define the model's default state.
     * Permit regex matching: /^DVO-\d{4}-\d{4,5}$/
     */
    public function definition(): array
    {
        return [
            'eatery_id' => Eatery::factory(),
            'permit_no' => 'DVO-'.fake()->numberBetween(2025, 2026).'-'.fake()->unique()->numberBetween(1000, 9999),
            'expires_on' => Carbon::now()->addMonths(fake()->numberBetween(2, 24))->format('Y-m-d'),
        ];
    }

    /**
     * Indicate that the permit is expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'expires_on' => Carbon::now()->subMonths(fake()->numberBetween(1, 10))->format('Y-m-d'),
        ]);
    }
}
