<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class provincias extends Model
{
    public function municipios()
    {
        return $this->hasMany('App\municipios');
    }
}
