<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    public function beritas()
    {
        return $this->belongsToMany('App\berita');
    }
}
