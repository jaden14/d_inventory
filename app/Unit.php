<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $guarded = [];

    public function stock()
    {
        return $this->hasMany('App\Stock');
    }

    public function item()
    {
        return $this->hasMany('App\Item');
    }

    public function release()
    {
        return $this->hasMany('App\Release');
    }
}
