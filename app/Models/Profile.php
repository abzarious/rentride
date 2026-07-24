<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = ['user_id', 'phone', 'address', 'nik', 'sim_number', 'photo'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}