<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class berita extends Model
{
    public function user()
    {
        return $this->belongsToMany('App\User');
    }

    public function categories()
    {
        return $this->belongsToMany('App\category');
    }
}
