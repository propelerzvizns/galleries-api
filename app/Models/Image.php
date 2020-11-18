<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'gallery_id',
        'img_url'
    ];

    public function gallery()
    {
        return $this->belongTo('App\Models\Gallery');
    }

}
