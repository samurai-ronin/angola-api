<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class municipios extends Model
{
    public function provincia()
    {
        return $this->belongsTo('App\provincias');
    }
}
