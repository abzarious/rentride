<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = ['code', 'title', 'discount_percentage', 'discount_amount', 'start_date', 'end_date', 'status'];
}