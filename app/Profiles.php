<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne('App\User');
    }
}