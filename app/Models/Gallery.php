<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];
    // public function comments()
    // {

    //     return $this->hasMany('App\Models\Comment');
    // }
    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

}
