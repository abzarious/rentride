<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Relasi ke tabel vehicles (Satu Tipe Kendaraan punya banyak Kendaraan)
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }
}