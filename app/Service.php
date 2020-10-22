<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
      'type',
    ];

    public function apartments() {
        return $this->belongsToMany('App\Apartment', 'apartment_service');
    }
}
