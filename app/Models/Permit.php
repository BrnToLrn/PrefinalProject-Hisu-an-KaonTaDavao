<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'eatery_id',
        'permit_no',
        'expires_on',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expires_on' => 'date',
        ];
    }

    /**
     * Get the eatery that owns the permit.
     */
    public function eatery(): BelongsTo
    {
        return $this->belongsTo(Eatery::class);
    }
}
