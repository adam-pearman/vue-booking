<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'from',
        'to'
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function scopeBetweenDates(Builder $query, $from, $to): Builder
    {
        return $query->where('to', '>=', $from)
            ->where('from', '<=', $to);
    }

    public static function findByReviewKey(string $reviewKey)
    {
        return static::where('review_key', $reviewKey)->with('booking')->first();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Reservation $reservation) {
            $reservation->review_key = Str::uuid();
        });
    }
}
