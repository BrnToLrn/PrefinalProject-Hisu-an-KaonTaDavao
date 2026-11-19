<?php

namespace Database\Factories;

use App\Models\District;
use App\Models\Eatery;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Eatery>
 */
class EateryFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $prefixes = [
            'Kaonan sa', 'Kusina ni', 'Ihaw-Ihaw ni', 'Kanto Kainang', 'Salo-Salo ni',
            'Lamesa sa', 'Chibugan sa', 'Pista sa', 'Balay Kaonan ni', 'Lugawan ug Silogan ni',
            'Sutukil ni', 'Davao Grill ni', 'Kambingan sa', 'Turo-Turo ni', 'Karenderya ni',
        ];
        $names = [
            'Neneng', 'Dodong', 'Bebeng', 'Tatay Juan', 'Manang Lita',
            'Kuya Jun', 'Ate Ging', 'Boying', 'Cardo', 'Inday',
            'Nonoy', 'Tata Romy', 'Nanay Belen', 'Mang Tomas', 'Aling Rosa',
            'Dante', 'Berting', 'Lando', 'Minda', 'Gorio',
        ];
        $specialties = [
            'Kinilaw & Sinuglaw', 'Balbacua Special', 'Inasal & Grilled Hito',
            'Bulalo Batangas Style', 'Tuna Panga & Belly', 'Lechon Kawali & Humba',
            'Ginataang Alimango', 'Native Chicken Tinola', 'Crispy Pata & Sisig',
        ];

        // Unique name generation
        $name = fake()->unique()->randomElement($prefixes).' '.fake()->randomElement($names).' '.fake()->unique()->numerify('##');

        // Authentic Davao City streets and landmarks
        $davaoStreets = [
            'Rizal Street, Poblacion, Davao City',
            'Claveria (Claro M. Recto) Avenue, Poblacion, Davao City',
            'San Pedro Street cor. Bolton St., Poblacion, Davao City',
            'C.M. Recto Ave cor. Marco Polo, Poblacion, Davao City',
            'Bolton Street cor. Bonifacio St., Poblacion, Davao City',
            'Ponciano Reyes Street, Poblacion, Davao City',
            'Matina Aplaya Road, Talomo, Davao City',
            'McArthur Highway, Matina Crossing, Talomo, Davao City',
            'Ecoland Drive cor. Quimpo Blvd, Talomo, Davao City',
            'Banga Beach Road, Talomo, Davao City',
            'Agdao Public Market Highway, Agdao, Davao City',
            'Lapu-Lapu Street, Agdao, Davao City',
            'Cabaguio Avenue, Agdao, Davao City',
            'Buhangin-Cabantian Road, Buhangin, Davao City',
            'Dacudao Avenue, Buhangin, Davao City',
            'Milan Road, Buhangin, Davao City',
            'Toril Public Market St., Toril, Davao City',
            'Daliao Fish Port Road, Toril, Davao City',
            'Crossing Bayabas, Toril, Davao City',
            'Tugbok Central Highway, Tugbok, Davao City',
            'Mintal Commercial Road, Tugbok, Davao City',
            'Bago Oshiro Crossing, Tugbok, Davao City',
            'Calinan Commercial Center Highway, Davao City',
            'Tibungco Public Market Highway, Davao City',
        ];

        // Unique name generation
        $name = fake()->unique()->randomElement($prefixes).' '.fake()->randomElement($names).' '.fake()->unique()->numerify('##');

        // Authentic Davao City streets and landmarks
        $davaoStreets = [
            'Rizal Street, Poblacion, Davao City',
            'Claveria (Claro M. Recto) Avenue, Poblacion, Davao City',
            'San Pedro Street cor. Bolton St., Poblacion, Davao City',
            'C.M. Recto Ave cor. Marco Polo, Poblacion, Davao City',
            'Bolton Street cor. Bonifacio St., Poblacion, Davao City',
            'Ponciano Reyes Street, Poblacion, Davao City',
            'Matina Aplaya Road, Talomo, Davao City',
            'McArthur Highway, Matina Crossing, Talomo, Davao City',
            'Ecoland Drive cor. Quimpo Blvd, Talomo, Davao City',
            'Banga Beach Road, Talomo, Davao City',
            'Agdao Public Market Highway, Agdao, Davao City',
            'Lapu-Lapu Street, Agdao, Davao City',
            'Cabaguio Avenue, Agdao, Davao City',
            'Buhangin-Cabantian Road, Buhangin, Davao City',
            'Dacudao Avenue, Buhangin, Davao City',
            'Milan Road, Buhangin, Davao City',
            'Toril Public Market St., Toril, Davao City',
            'Daliao Fish Port Road, Toril, Davao City',
            'Crossing Bayabas, Toril, Davao City',
            'Tugbok Central Highway, Tugbok, Davao City',
            'Mintal Commercial Road, Tugbok, Davao City',
            'Bago Oshiro Crossing, Tugbok, Davao City',
            'Calinan Commercial Center Highway, Davao City',
            'Tibungco Public Market Highway, Davao City',
        ];

        return [
            'district_id' => District::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => fake()->randomElement($davaoStreets),
            'price_range' => fake()->randomElement(['budget', 'mid', 'splurge']),
            'specialty' => fake()->randomElement($specialties),
            'is_open' => true,
        ];
    }

    /**
     * Indicate that the eatery is closed.
     */
    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_open' => false,
        ]);
    }
}
