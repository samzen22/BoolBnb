<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [
      'date',
      'apartment_id',
    ];

    public function apartment() {
        return $this->belongsTo('App\Apartment');
    }
}
