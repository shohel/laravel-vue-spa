<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];
    protected $hidden = ['pivot'];

    public function posts(){
        return $this->belongsToMany(Post::class);
    }
}
