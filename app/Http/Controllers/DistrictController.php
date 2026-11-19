<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Contracts\View\View;

class DistrictController extends Controller
{
    /**
     * Display a listing of districts.
     */
    public function index(): View
    {
        $districts = District::withCount('eateries')
            ->orderBy('name')
            ->get();

        return view('districts.index', [
            'districts' => $districts,
        ]);
    }

    /**
     * Display the specified district.
     */
    public function show(District $district): View
    {
        $district->load([
            'eateries.district',
            'eateries.features',
        ]);
        $district->eateries->loadAvg('reviews', 'rating');
        $district->eateries->loadCount('reviews');

        $reviewsCount = $district->reviews()->count();

        return view('districts.show', [
            'district' => $district,
            'reviewsCount' => $reviewsCount,
        ]);
    }
}
