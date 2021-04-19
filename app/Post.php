<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'thumbnail', 'slug', 'user_id'];
    protected $dates = ['created_at']; // instansiasi dr karbon

    public function user()
    {
        return $this->belongsTo(User::class); // relasi ke tabel user (dimiliki)
    }

    public function thumbnail()
    {
        // if($this->thumbnail) { // $this, mengacu pada class bersangkutan {{asset('/frontend')}}/img/b1.jpg
        //     return $this->thumbnail;
        // }
        // else
        // {
        //     return asset('frontend/img/no-thumbnail-blue.png');
        // }

        // here's the clean code, call the wrong condition first
        // if(!$this->thumbnail) {
        //     return asset('frontend/img/no-thumbnail-blue.png');
        // }
        // return $this->thumbnail;

        // here's use the short code
        return !$this->thumbnail ? asset('frontend/img/no-thumbnail-blue.png') : $this->thumbnail;

    }
}
