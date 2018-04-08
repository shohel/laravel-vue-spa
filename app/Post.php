<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $guarded = [];

    public function getCreatedAtAttribute($value){
        $dt = Carbon::createFromTimeString($value);
        return $dt->diffForHumans();
    }

    public function getUpdatedAtAttribute($value){
        $dt = Carbon::createFromTimeString($value);
        return $dt->diffForHumans();
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
