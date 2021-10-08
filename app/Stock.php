<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $guarded = [];

    public function unit()
    {
        return $this->belongsTo('App\unit');
    }

    public function item()
    {
        return $this->hasMany('App\Item');
    }
}
