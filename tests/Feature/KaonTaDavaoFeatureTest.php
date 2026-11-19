<?php

namespace Tests\Feature;

use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KaonTaDavaoFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test home page renders 3 counts, top rated section and branding.
     */
    public function test_home_page_displays_counts_and_top_rated_eateries(): void
    {
        $district = District::create(['name' => 'Poblacion']);
        $user = User::create([
            'name' => 'Al Franzianne Hisu-an',
            'email' => 'hisu-an@kaonta.test',
            'password' => bcrypt('password'),
        ]);

        $eatery = Eatery::create([
            'district_id' => $district->id,
            'name' => 'Carinderia ni Hisu-an',
            'slug' => 'carinderia-ni-hisu-an',
            'address' => 'Claveria St, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinola Manok Bisaya',
            'is_open' => true,
        ]);

        Review::create([
            'eatery_id' => $eatery->id,
            'user_id' => $user->id,
            'rating' => 5,
            'body' => 'Delicious comforting food in Davao!',
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee("Kaon Ta! Davao - Hisu-an's Food Guide");
        $response->assertSee('Total Eateries');
        $response->assertSee('Districts Covered');
        $response->assertSee('Community Reviews');
        $response->assertSee('Top Rated');
        $response->assertSee('Carinderia ni Hisu-an');
    }

    /**
     * Test eatery listing with filters and empty states.
     */
    public function test_eatery_index_and_filters(): void
    {
        $district1 = District::create(['name' => 'Talomo']);
        $district2 = District::create(['name' => 'Agdao']);
        $feature = Feature::create(['name' => 'Suki ni Hisu-an']);

        $eatery1 = Eatery::create([
            'district_id' => $district1->id,
            'name' => 'Carinderia ni Hisu-an',
            'slug' => 'carinderia-ni-hisu-an',
            'address' => 'Talomo, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinola',
            'is_open' => true,
        ]);
        $eatery1->features()->attach($feature);

        $eatery2 = Eatery::create([
            'district_id' => $district2->id,
            'name' => 'Agdao Kinilaw House',
            'slug' => 'agdao-kinilaw-house',
            'address' => 'Agdao, Davao City',
            'price_range' => 'mid',
            'specialty' => 'Kinilaw',
            'is_open' => true,
        ]);

        // No filter
        $response = $this->get(route('eateries.index'));
        $response->assertStatus(200);
        $response->assertSee('Carinderia ni Hisu-an');
        $response->assertSee('Agdao Kinilaw House');

        // Filter by q (specialty)
        $qResponse = $this->get(route('eateries.index', ['q' => 'Kinilaw']));
        $qResponse->assertSee('Agdao Kinilaw House');
        $qResponse->assertDontSee('Carinderia ni Hisu-an');

        // Filter by feature
        $featResponse = $this->get(route('eateries.index', ['feature' => 'Suki ni Hisu-an']));
        $featResponse->assertSee('Carinderia ni Hisu-an');
        $featResponse->assertDontSee('Agdao Kinilaw House');

        // Empty filter state
        $emptyResponse = $this->get(route('eateries.index', ['q' => 'NonExistentDish']));
        $emptyResponse->assertSee('No eateries match your filters.');
    }

    /**
     * Test creating an eatery with permit and features.
     */
    public function test_can_create_eatery_with_permit_and_features(): void
    {
        $district = District::create(['name' => 'Poblacion']);
        $feature = Feature::create(['name' => 'Suki ni Hisu-an']);

        $response = $this->post(route('eateries.store'), [
            'name' => 'New Carinderia Davao',
            'district_id' => $district->id,
            'address' => 'San Pedro St, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Sinuglaw',
            'is_open' => 1,
            'permit_no' => 'DVO-2026-9999',
            'expires_on' => Carbon::tomorrow()->format('Y-m-d'),
            'features' => [$feature->id],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Eatery added.');

        $this->assertDatabaseHas('eateries', [
            'name' => 'New Carinderia Davao',
            'slug' => 'new-carinderia-davao',
            'price_range' => 'budget',
        ]);

        $this->assertDatabaseHas('permits', [
            'permit_no' => 'DVO-2026-9999',
        ]);
    }

    /**
     * Test exact custom validation messages for Eatery.
     */
    public function test_eatery_exact_custom_validation_messages(): void
    {
        $district = District::create(['name' => 'Poblacion']);
        $feature = Feature::create(['name' => 'Suki ni Hisu-an']);

        Eatery::create([
            'district_id' => $district->id,
            'name' => 'Duplicate Eatery',
            'slug' => 'duplicate-eatery',
            'address' => 'San Pedro St, Davao City',
            'price_range' => 'budget',
            'is_open' => true,
        ]);

        $response = $this->post(route('eateries.store'), [
            'name' => 'Duplicate Eatery',
            'district_id' => $district->id,
            'address' => 'Somewhere',
            'price_range' => 'budget',
            'permit_no' => 'INVALID-FORMAT',
            'expires_on' => Carbon::yesterday()->format('Y-m-d'),
            // features omitted to trigger features.required
        ]);

        $response->assertSessionHasErrors([
            'name' => 'Kaon Ta Hisu-an already lists an eatery with this name.',
            'features' => 'Pick at least one feature.',
            'permit_no' => 'Permit number must look like DVO-2026-0202.',
            'expires_on' => 'The permit must not be expired.',
        ]);
    }

    /**
     * Test updating an eatery.
     */
    public function test_can_update_eatery_and_permit(): void
    {
        $district = District::create(['name' => 'Poblacion']);
        $feature = Feature::create(['name' => 'Suki ni Hisu-an']);

        $eatery = Eatery::create([
            'district_id' => $district->id,
            'name' => 'Original Name',
            'slug' => 'original-name',
            'address' => 'Some St, Davao City',
            'price_range' => 'budget',
            'is_open' => true,
        ]);

        $eatery->permit()->create([
            'permit_no' => 'DVO-2026-1111',
            'expires_on' => Carbon::now()->addYear()->format('Y-m-d'),
        ]);

        $response = $this->put(route('eateries.update', $eatery), [
            'name' => 'Updated Name',
            'district_id' => $district->id,
            'address' => 'Updated St, Davao City',
            'price_range' => 'mid',
            'specialty' => 'Updated Specialty',
            'is_open' => 1,
            'permit_no' => 'DVO-2026-1111', // same permit, unique check must ignore
            'expires_on' => Carbon::now()->addYear()->format('Y-m-d'),
            'features' => [$feature->id],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Eatery updated.');

        $this->assertDatabaseHas('eateries', [
            'id' => $eatery->id,
            'name' => 'Updated Name',
            'slug' => 'updated-name',
            'price_range' => 'mid',
        ]);
    }

    /**
     * Test destroying an eatery cleans up child records.
     */
    public function test_destroy_eatery_and_child_relations(): void
    {
        $district = District::create(['name' => 'Poblacion']);
        $feature = Feature::create(['name' => 'Suki ni Hisu-an']);
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@kaonta.test',
            'password' => bcrypt('password'),
        ]);

        $eatery = Eatery::create([
            'district_id' => $district->id,
            'name' => 'Delete Me Eatery',
            'slug' => 'delete-me-eatery',
            'address' => 'Delete St',
            'price_range' => 'budget',
            'is_open' => true,
        ]);
        $eatery->permit()->create([
            'permit_no' => 'DVO-2026-2222',
            'expires_on' => Carbon::now()->addYear()->format('Y-m-d'),
        ]);
        $eatery->dishes()->create(['name' => 'Dish 1', 'price' => 50]);
        $eatery->reviews()->create(['user_id' => $user->id, 'rating' => 4, 'body' => 'Good tasting dish!']);
        $eatery->features()->attach($feature);

        $response = $this->delete(route('eateries.destroy', $eatery));
        $response->assertRedirect(route('eateries.index'));
        $response->assertSessionHas('success', 'Eatery deleted.');

        $this->assertDatabaseMissing('eateries', ['id' => $eatery->id]);
        $this->assertDatabaseMissing('permits', ['permit_no' => 'DVO-2026-2222']);
        $this->assertDatabaseMissing('dishes', ['name' => 'Dish 1']);
        $this->assertDatabaseMissing('reviews', ['body' => 'Good tasting dish!']);
        $this->assertDatabaseMissing('eatery_feature', ['eatery_id' => $eatery->id]);
    }

    /**
     * Test eatery show page with permit expiry, menu dishes, and closed state.
     * Also tests that posting a review to a closed eatery returns HTTP 403 Forbidden.
     */
    public function test_eatery_show_and_closed_review_returns_403(): void
    {
        $district = District::create(['name' => 'Toril']);
        $user = User::create([
            'name' => 'Tita Hisu-an',
            'email' => 'tita.hisu-an@kaonta.test',
            'password' => bcrypt('password'),
        ]);

        // Closed eatery with expired permit
        $eatery = Eatery::create([
            'district_id' => $district->id,
            'name' => 'Seaside Grill Toril',
            'slug' => 'seaside-grill-toril',
            'address' => 'Toril, Davao City',
            'price_range' => 'mid',
            'specialty' => 'Inihaw na Bangus',
            'is_open' => false,
        ]);

        $eatery->permit()->create([
            'permit_no' => 'DVO-2025-0101',
            'expires_on' => Carbon::now()->subMonth()->format('Y-m-d'),
        ]);

        $eatery->dishes()->create([
            'name' => 'Inihaw Bangus Large',
            'price' => 180.00,
            'is_bestseller' => true,
        ]);

        $response = $this->get(route('eateries.show', $eatery));
        $response->assertStatus(200);
        $response->assertSee('Permit expired');
        $response->assertSee('Bestseller');
        $response->assertSee('₱180.00');
        $response->assertSee('This eatery is closed. Reviews are paused.');

        // Attempting to post review on closed eatery must return 403 (Section 7.3)
        $reviewPost = $this->post(route('eateries.reviews.store', $eatery), [
            'user_id' => $user->id,
            'rating' => 5,
            'body' => 'Should return 403 forbidden because eatery is closed.',
        ]);
        $reviewPost->assertStatus(403);
    }

    /**
     * Test submitting a review on an open eatery and deleting review.
     */
    public function test_submitting_and_deleting_review_on_open_eatery(): void
    {
        $district = District::create(['name' => 'Poblacion']);
        $user = User::create([
            'name' => 'Al Franzianne Hisu-an',
            'email' => 'hisu-an@kaonta.test',
            'password' => bcrypt('password'),
        ]);

        $eatery = Eatery::create([
            'district_id' => $district->id,
            'name' => 'Carinderia ni Hisu-an',
            'slug' => 'carinderia-ni-hisu-an',
            'address' => 'Claveria St, Davao City',
            'price_range' => 'budget',
            'is_open' => true,
        ]);

        // Validation error test on review fields
        $invalidReview = $this->post(route('eateries.reviews.store', $eatery), [
            'rating' => 6,
            'body' => 'Too short',
        ]);
        $invalidReview->assertSessionHasErrors([
            'user_id' => 'Choose who is writing this review.',
            'rating' => 'Ratings go from 1 to 5 stars only.',
            'body' => 'Kaon Ta Hisu-an: reviews need at least 10 characters.',
        ]);

        // Valid review
        $response = $this->post(route('eateries.reviews.store', $eatery), [
            'user_id' => $user->id,
            'rating' => 5,
            'body' => 'Lami kaayo ang sabaw ug humba sa Davao!',
        ]);

        $response->assertRedirect(route('eateries.show', $eatery));
        $response->assertSessionHas('success', 'Salamat! Review posted.');

        $review = Review::where('eatery_id', $eatery->id)->first();
        $this->assertNotNull($review);

        // Delete review
        $deleteResponse = $this->delete(route('reviews.destroy', $review));
        $deleteResponse->assertRedirect(route('eateries.show', $eatery));
        $deleteResponse->assertSessionHas('success', 'Review deleted.');
        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }

    /**
     * Test district show page counts reviews through Eatery (hasManyThrough).
     */
    public function test_district_show_counts_reviews_through_eatery(): void
    {
        $district = District::create(['name' => 'Talomo']);
        $user = User::create([
            'name' => 'Al Franzianne Hisu-an',
            'email' => 'hisu-an@kaonta.test',
            'password' => bcrypt('password'),
        ]);

        $eatery = Eatery::create([
            'district_id' => $district->id,
            'name' => 'Matina BBQ House',
            'slug' => 'matina-bbq-house',
            'address' => 'Matina, Talomo, Davao City',
            'price_range' => 'budget',
            'is_open' => true,
        ]);

        Review::create([
            'eatery_id' => $eatery->id,
            'user_id' => $user->id,
            'rating' => 4,
            'body' => 'Good pork bbq skewers!',
        ]);

        $response = $this->get(route('districts.show', $district));
        $response->assertStatus(200);
        $response->assertSee('1 review in Talomo');
    }

    /**
     * Test reviewer profile page shows count and user reviews.
     */
    public function test_reviewer_page_shows_reviews(): void
    {
        $district = District::create(['name' => 'Agdao']);
        $user = User::create([
            'name' => 'Al Franzianne Hisu-an',
            'email' => 'hisu-an@kaonta.test',
            'password' => bcrypt('password'),
        ]);

        $eatery = Eatery::create([
            'district_id' => $district->id,
            'name' => 'Agdao Fresh Tuna',
            'slug' => 'agdao-fresh-tuna',
            'address' => 'Agdao, Davao City',
            'price_range' => 'budget',
            'is_open' => true,
        ]);

        Review::create([
            'eatery_id' => $eatery->id,
            'user_id' => $user->id,
            'rating' => 5,
            'body' => 'Super fresh yellowfin tuna.',
        ]);

        $response = $this->get(route('reviewers.show', $user));
        $response->assertStatus(200);
        $response->assertSee('Al Franzianne Hisu-an');
        $response->assertSee('1 review written');
        $response->assertSee('Super fresh yellowfin tuna.');
    }
}
