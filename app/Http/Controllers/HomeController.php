<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Eatery;
use App\Models\Review;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $eateriesCount = Eatery::count();
        $districtsCount = District::count();
        $reviewsCount = Review::count();

        // Top 3 eateries that have the highest average rating (only eateries with at least 1 review)
        $topEateries = Eatery::with(['district', 'features'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->has('reviews')
            ->orderByDesc('reviews_avg_rating')
            ->orderByDesc('reviews_count')
            ->take(3)
            ->get();

        return view('home', [
            'eateriesCount' => $eateriesCount,
            'districtsCount' => $districtsCount,
            'reviewsCount' => $reviewsCount,
            'topEateries' => $topEateries,
        ]);
    }
}
