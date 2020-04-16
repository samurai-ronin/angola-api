<?php

namespace App;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class municipios extends Model
{
    public function provincia()
    {
        return $this->belongsTo('App\provincias');
    }
}
