<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dish extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'eatery_id',
        'name',
        'price',
        'is_bestseller',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_bestseller' => 'boolean',
        ];
    }

    /**
     * Get the eatery that owns the dish.
     */
    public function eatery(): BelongsTo
    {
        return $this->belongsTo(Eatery::class);
    }
}
