<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Exactly 12 users:
     * - [Firstname] [Lastname] (hisu-an@kaonta.test) password: kaonta2026 hashed
     * - Tita [Lastname] (tita.hisu-an@kaonta.test) password: kaonta2026 hashed
     * - plus 10 factory users.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'hisu-an@kaonta.test'],
            [
                'name' => 'Al Franzianne Hisu-an',
                'password' => Hash::make('kaonta2026'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'tita.hisu-an@kaonta.test'],
            [
                'name' => 'Tita Hisu-an',
                'password' => Hash::make('kaonta2026'),
            ]
        );

        User::factory()->count(10)->create([
            'password' => Hash::make('kaonta2026'),
        ]);
    }
}
