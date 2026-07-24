<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penalty extends Model
{
    protected $fillable = ['booking_id', 'amount', 'reason', 'status'];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}