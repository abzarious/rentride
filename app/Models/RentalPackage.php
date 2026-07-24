<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalPackage extends Model
{
    protected $fillable = ['name', 'duration_hours'];
}
