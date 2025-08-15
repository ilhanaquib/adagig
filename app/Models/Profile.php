<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Profile extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'user_profile';

    protected $fillable = [
        'bio',
        'location',
        'links',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_picture')->singleFile(); // only 1 profile picture
        $this->addMediaCollection('wallpaper')->singleFile(); // only 1 wallpaper
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
