<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'body',
        'gallery_id'
    ];

    public function gallery(){
        return $this->belongsTo(Gallery::class);
    }
}
