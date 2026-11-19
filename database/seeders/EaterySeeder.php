<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Permit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EaterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Total eateries: 15 (1 your eatery + 14 factory eateries, exactly 3 of which are closed).
     * 15 permits total.
     * Note: Dishes are seeded in DishSeeder.
     */
    public function run(): void
    {
        $districts = District::all();
        $features = Feature::all();
        $poblacion = District::where('name', 'Poblacion')->first();

        $featureSuki = Feature::where('name', 'Suki ni Hisu-an')->first();
        $featureBudget = Feature::where('name', 'Budget Meal')->first();

        // 1. Your hand-made eatery (not made by factory)
        $handMadeName = 'Carinderia ni Hisu-an';
        $yourEatery = Eatery::create([
            'district_id' => $poblacion->id,
            'name' => $handMadeName,
            'slug' => Str::slug($handMadeName),
            'address' => 'San Pedro St., Poblacion, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinolang Manok',
            'is_open' => true,
        ]);

        // Features set with sync() to exactly Suki ni [Lastname] and Budget Meal
        $yourEatery->features()->sync([$featureSuki->id, $featureBudget->id]);

        // Permit DVO-2026-[MMDD] expiring on your birthday in 2027, created through relationship
        $yourEatery->permit()->create([
            'permit_no' => 'DVO-2026-0202',
            'expires_on' => '2027-02-02',
        ]);

        // 2. Other eateries (14 from EateryFactory, in random districts, exactly 3 closed)
        for ($i = 1; $i <= 14; $i++) {
            $isClosed = ($i <= 3); // exactly 3 made with closed() state
            $district = $districts->random();

            $factoryEatery = $isClosed
                ? Eatery::factory()->closed()->create(['district_id' => $district->id])
                : Eatery::factory()->create(['district_id' => $district->id]);

            // 1 permit: at least one already expired (e.g. for the first 2)
            $isExpired = ($i <= 2);
            if ($isExpired) {
                Permit::factory()->expired()->create(['eatery_id' => $factoryEatery->id]);
            } else {
                Permit::factory()->create(['eatery_id' => $factoryEatery->id]);
            }

            // 1-3 random features attached with attach()
            $randomFeatures = $features->random(rand(1, 3));
            foreach ($randomFeatures as $feat) {
                $factoryEatery->features()->attach($feat->id);
            }
        }
    }
}
