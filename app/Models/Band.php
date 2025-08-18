<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Band extends Model implements HasMedia
{

    use InteractsWithMedia;
    //
    protected $fillable = [
        'name',
        'genre',
        'description',
        'location',
        'links',
    ];

    public function getRouteKeyName()
    {
        return 'slug'; 
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'band_user', 'band_id', 'user_id')
            ->withTimestamps();
    }
}
