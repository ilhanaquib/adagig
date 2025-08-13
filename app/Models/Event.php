<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'location',
        'date',
        'time',
        'ticket_url',
        'ticket_price',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
    ];
}
