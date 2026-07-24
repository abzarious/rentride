<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleImage extends Model
{
    protected $fillable = ['vehicle_id', 'image', 'is_primary'];

    public function vehicles() : BelongsTo 
    {   
        return $this->belongsTo(Vehicle::class);
        
    }
}
