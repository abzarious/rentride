<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['company_name', 'logo', 'primary_color', 'secondary_color', 'whatsapp', 'address', 'bank_rekening'];
}