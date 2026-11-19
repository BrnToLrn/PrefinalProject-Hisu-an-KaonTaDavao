<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Exactly 6 districts: Poblacion, Talomo, Agdao, Buhangin, Toril, plus Tugbok.
     */
    public function run(): void
    {
        $districts = [
            'Poblacion',
            'Talomo',
            'Agdao',
            'Buhangin',
            'Toril',
            'Tugbok',
        ];

        foreach ($districts as $name) {
            District::firstOrCreate(['name' => $name]);
        }
    }
}
