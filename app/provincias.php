<?php

namespace App;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class provincias extends Model
{
    public function municipios()
    {
        return $this->hasMany('App\municipios');
    }
}
