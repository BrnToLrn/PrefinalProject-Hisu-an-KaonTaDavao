<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;

class ReviewerController extends Controller
{
    /**
     * Display the reviewer's profile and their reviews.
     */
    public function show(User $user): View
    {
        $user->load([
            'reviews' => function ($query) {
                $query->with('eatery')->latest();
            },
        ]);

        $reviewsCount = $user->reviews->count();

        return view('reviewers.show', [
            'reviewer' => $user,
            'reviewsCount' => $reviewsCount,
        ]);
    }
}
