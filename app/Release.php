<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

     public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
}
