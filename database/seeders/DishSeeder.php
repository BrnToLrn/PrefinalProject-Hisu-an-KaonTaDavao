<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Eatery;
use Illuminate\Database\Seeder;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeds dishes for all eateries:
     * - Exactly 3 dishes for 'Carinderia ni Hisu-an':
     *   Tinolang Manok 85.00 (bestseller), Kinilaw na Tuna 120.00, Durian Shake 75.00
     * - 2-5 dishes for each other factory eatery via DishFactory
     */
    public function run(): void
    {
        $yourEatery = Eatery::where('slug', 'carinderia-ni-hisu-an')->first();

        if ($yourEatery) {
            $yourEatery->dishes()->createMany([
                ['name' => 'Tinolang Manok', 'price' => 85.00, 'is_bestseller' => true],
                ['name' => 'Kinilaw na Tuna', 'price' => 120.00, 'is_bestseller' => false],
                ['name' => 'Durian Shake', 'price' => 75.00, 'is_bestseller' => false],
            ]);
        }

        // Dishes for other factory eateries: 2-5 dishes each
        $otherEateries = Eatery::where('id', '!=', $yourEatery?->id)->get();

        foreach ($otherEateries as $eatery) {
            $dishCount = rand(2, 5);
            Dish::factory()->count($dishCount)->create([
                'eatery_id' => $eatery->id,
            ]);
        }
    }
}
