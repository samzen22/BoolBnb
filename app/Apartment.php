<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = [
      'title',
      'description',
      'rooms',
      'beds',
      'baths',
      'square_meters',
      'address',
      'lat',
      'lon',
      'price',
      'image',
      'active',
      'user_id',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function sponsorships() {
        return $this->belongsToMany('App\Sponsorship')->withPivot('apartment_id', 'sponsorship_id', 'start_date', 'end_date');
    }

    public function services() {
        return $this->belongsToMany('App\Service', 'apartment_service');
    }

    public function images() {
        return $this->hasMany('App\Image');
    }

    public function messages() {
        return $this->hasMany('App\Message');
    }

    public function views() {
        return $this->hasMany('App\View');
    }
}
