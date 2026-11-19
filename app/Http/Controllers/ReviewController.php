<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Eatery;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(StoreReviewRequest $request, Eatery $eatery): RedirectResponse
    {
        $validated = $request->validated();

        // create the review through the eatery's relationship
        $eatery->reviews()->create($validated);

        return redirect()->route('eateries.show', $eatery)
            ->with('success', 'Salamat! Review posted.');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review): RedirectResponse
    {
        $eatery = $review->eatery;
        $review->delete();

        return redirect()->route('eateries.show', $eatery)
            ->with('success', 'Review deleted.');
    }
}
