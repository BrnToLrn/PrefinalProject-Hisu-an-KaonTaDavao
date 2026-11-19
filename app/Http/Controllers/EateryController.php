<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEateryRequest;
use App\Http\Requests\UpdateEateryRequest;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EateryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Eatery::with(['district', 'features'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        // ?q= (matches name or specialty)
        if ($request->filled('q')) {
            $searchTerm = '%'.$request->input('q').'%';
            $query->where(function ($sub) use ($searchTerm) {
                $sub->where('name', 'like', $searchTerm)
                    ->orWhere('specialty', 'like', $searchTerm);
            });
        }

        // ?district= (district id, a select)
        if ($request->filled('district')) {
            $query->where('district_id', $request->input('district'));
        }

        // ?feature= (feature name, a select)
        if ($request->filled('feature')) {
            $featureName = $request->input('feature');
            $query->whereHas('features', function ($sub) use ($featureName) {
                $sub->where('name', $featureName);
            });
        }

        $eateries = $query->orderBy('name', 'asc')->paginate(6)->withQueryString();

        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.index', [
            'eateries' => $eateries,
            'districts' => $districts,
            'features' => $features,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.create', [
            'districts' => $districts,
            'features' => $features,
            'eatery' => new Eatery,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEateryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $eatery = Eatery::create([
            'district_id' => $validated['district_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'address' => $validated['address'],
            'price_range' => $validated['price_range'],
            'specialty' => $validated['specialty'] ?? null,
            'is_open' => (bool) $validated['is_open'],
        ]);

        // create its permit through the hasOne relationship
        $eatery->permit()->create([
            'permit_no' => $validated['permit_no'],
            'expires_on' => $validated['expires_on'],
        ]);

        // set its features with sync()
        $eatery->features()->sync($validated['features'] ?? []);

        return redirect()->route('eateries.show', $eatery)
            ->with('success', 'Eatery added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Eatery $eatery): View
    {
        // Eager-load relations for eatery page
        $eatery->load([
            'district',
            'features',
            'permit',
            'dishes',
            'reviews.user',
        ]);
        $eatery->loadAvg('reviews', 'rating');
        $eatery->loadCount('reviews');

        $users = User::orderBy('name')->get();

        return view('eateries.show', [
            'eatery' => $eatery,
            'users' => $users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Eatery $eatery): View
    {
        $eatery->load(['permit', 'features']);
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.edit', [
            'eatery' => $eatery,
            'districts' => $districts,
            'features' => $features,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEateryRequest $request, Eatery $eatery): RedirectResponse
    {
        $validated = $request->validated();

        $eatery->update([
            'district_id' => $validated['district_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'address' => $validated['address'],
            'price_range' => $validated['price_range'],
            'specialty' => $validated['specialty'] ?? null,
            'is_open' => (bool) $validated['is_open'],
        ]);

        // update its permit through hasOne relationship
        $eatery->permit()->updateOrCreate(
            ['eatery_id' => $eatery->id],
            [
                'permit_no' => $validated['permit_no'],
                'expires_on' => $validated['expires_on'],
            ]
        );

        // and its features (sync())
        $eatery->features()->sync($validated['features'] ?? []);

        return redirect()->route('eateries.show', $eatery)
            ->with('success', 'Eatery updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Eatery $eatery): RedirectResponse
    {
        // Delete related permit, dishes, reviews, and feature pivot rows through relationships
        $eatery->permit()?->delete();
        $eatery->dishes()->delete();
        $eatery->reviews()->delete();
        $eatery->features()->detach();

        $eatery->delete();

        return redirect()->route('eateries.index')
            ->with('success', 'Eatery deleted.');
    }
}
