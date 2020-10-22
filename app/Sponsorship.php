<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    protected $fillable = [
      'name',
      'duration',
      'price',
    ];

    public function apartments() {
        return $this->belongsToMany('App\Apartment')->withPivot('apartment_id', 'sponsorship_id', 'start_date', 'end_date');
    }
}
