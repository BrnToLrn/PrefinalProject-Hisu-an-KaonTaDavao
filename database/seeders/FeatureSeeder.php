<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Exactly 6 features: Suki ni [Lastname], Budget Meal, Halal, Open 24 Hours, Aircon, plus Free Wi-Fi.
     */
    public function run(): void
    {
        $features = [
            'Suki ni Hisu-an',
            'Budget Meal',
            'Halal',
            'Open 24 Hours',
            'Aircon',
            'Free Wi-Fi',
        ];

        foreach ($features as $name) {
            Feature::firstOrCreate(['name' => $name]);
        }
    }
}
