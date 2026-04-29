<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'start_date',
        'end_date',
        'guests',
        'message',
        'is_read',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_read' => 'boolean',
        'guests' => 'integer',
    ];
}
