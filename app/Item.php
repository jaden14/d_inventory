<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];

    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
}
