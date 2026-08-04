<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'vehicle_id',
        'start_date',
        'end_date',
        'duration_days',
        'price_per_day',
        'subtotal',
        'discount',
        'total_price',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'duration_days' => 'integer',
        'price_per_day' => 'integer',
        'subtotal' => 'integer',
        'discount' => 'integer',
        'total_price' => 'integer',
    ];

    // --- ENUM / CONSTANT STATUS BOOKING ---
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_ONGOING = 'ongoing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    // --- RELASI ELOQUENT ---
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class)->withTrashed();
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function penalties(): HasMany
    {
        return $this->hasMany(Penalty::class);
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(BookingStatusLog::class);
    }

    public function rentalPackage(): BelongsTo
    {
        return $this->belongsTo(RentalPackage::class);
    }
}