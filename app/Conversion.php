<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    protected $table = 'conversions';

    public function users()
    {
        return $this->belongsTo('App\User', 'userID');
    }
}
