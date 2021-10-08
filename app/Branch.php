<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $guarded = [];

    public function release()
    {
        return $this->hasMany('App\Release');
    }
}
