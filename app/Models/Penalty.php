<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'late_minutes',
        'late_hours',
        'amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'late_minutes' => 'integer',
        'late_hours'   => 'integer',
        'amount'       => 'integer',
    ];

    // Status Constants
    public const STATUS_UNPAID = 'unpaid';
    public const STATUS_PAID   = 'paid';

    /**
     * Relasi ke Booking
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}