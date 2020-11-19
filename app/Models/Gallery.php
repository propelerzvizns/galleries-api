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
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
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
    public static function searchByAuthor($id, $title){
        $galleries = Gallery::with('user', 'images')->where('title', 'like', '%'. $title .'%')->where('user_id', $id)->paginate(10);
        if($galleries->isEmpty()){
            return Gallery::query();
        } else {
            return $galleries;
        }
    }


}
