<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ads extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'price',
        'category',
        'user_id',
        'description',
        'main_image',
        'location'
    ];
    public function user ()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function images()
{
    return $this->hasMany(Image::class);
}
}
