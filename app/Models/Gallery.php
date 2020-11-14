<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\DB;
use App\Models\User;

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
        return $this->hasMany(Image::class);
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public static function search($title){
            $galleries = Gallery::with('user','images')
            ->where('title', 'like', '%'. $title .'%')
            ->paginate(10);

        if($galleries->isEmpty()){

            return Gallery::query();
        } else {

            return $galleries;
        }

    }

}
