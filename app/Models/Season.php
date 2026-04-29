<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = ['name', 'slug', 'start_date', 'end_date', 'price_per_night', 'price_per_week', 'color'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price_per_night' => 'decimal:2',
        'price_per_week' => 'decimal:2',
    ];
}
