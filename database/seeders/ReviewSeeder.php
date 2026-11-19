<?php

namespace Database\Seeders;

use App\Models\Eatery;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Your eatery reviews: at least 3, including one by Tita [Lastname] with rating 5 and body:
     * "Lami kaayo! Balik-balikan ni Tita [Lastname]."
     * Other reviews: each open factory eatery gets 0-6 reviews by random users (rating 1-5). Closed eateries get none.
     */
    public function run(): void
    {
        $users = User::all();
        $studentUser = User::where('email', 'hisu-an@kaonta.test')->first();
        $titaUser = User::where('email', 'tita.hisu-an@kaonta.test')->first();

        $yourEatery = Eatery::where('slug', 'carinderia-ni-hisu-an')->first();

        if ($yourEatery) {
            // Review 1: Exactly by Tita [Lastname]
            Review::create([
                'eatery_id' => $yourEatery->id,
                'user_id' => $titaUser ? $titaUser->id : $users->first()->id,
                'rating' => 5,
                'body' => 'Lami kaayo! Balik-balikan ni Tita Hisu-an.',
                'created_at' => Carbon::now()->subDays(1),
            ]);

            // Review 2: By student user
            Review::create([
                'eatery_id' => $yourEatery->id,
                'user_id' => $studentUser ? $studentUser->id : $users->last()->id,
                'rating' => 5,
                'body' => 'Super authentic Davao comfort food, generous serving of Tinolang Manok!',
                'created_at' => Carbon::now()->subDays(2),
            ]);

            // Review 3: By another user
            $otherUser = $users->whereNotIn('id', [$titaUser?->id, $studentUser?->id])->first() ?? $users->first();
            Review::create([
                'eatery_id' => $yourEatery->id,
                'user_id' => $otherUser->id,
                'rating' => 5,
                'body' => 'Very welcoming atmosphere and clean dining area. The Durian Shake is a must try!',
                'created_at' => Carbon::now()->subDays(3),
            ]);
        }

        // Other reviews: Each OPEN factory eatery gets 0-6 reviews by random users. Closed eateries get none.
        $otherEateries = Eatery::where('id', '!=', $yourEatery?->id)->get();

        foreach ($otherEateries as $eatery) {
            if (! $eatery->is_open) {
                // Closed eateries get none
                continue;
            }

            $reviewsToCreate = rand(0, 6);
            if ($reviewsToCreate > 0) {
                $reviewers = $users->random(min($reviewsToCreate, $users->count()));
                foreach ($reviewers as $reviewer) {
                    Review::factory()->create([
                        'eatery_id' => $eatery->id,
                        'user_id' => $reviewer->id,
                    ]);
                }
            }
        }
    }
}
