<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class District extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the eateries in this district.
     */
    public function eateries(): HasMany
    {
        return $this->hasMany(Eatery::class);
    }

    /**
     * Get all reviews for eateries in this district.
     */
    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(Review::class, Eatery::class);
    }
}
