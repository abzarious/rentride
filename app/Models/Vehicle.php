<?php

namespace App\Models;

use App\Enums\VehicleStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'brand_id',
        'category_id',
        'vehicle_type_id',
        'name',
        'plate_number',
        'year',
        'color',
        'price_per_day',
        'transmission',
        'fuel_type',
        'thumbnail',
        'description',
        'status',
    ];

    /**
     * Casting Enum Status
     */
    protected $casts = [
        'status' => VehicleStatus::class,
        'price_per_day' => 'integer',
    ];

    // --- RELASI ELOQUENT ---

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(VehicleCategory::class, 'category_id');
    }

    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }
}