<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Apartment;
use App\Sponsorship;

class SearchController extends Controller
{
  public function view(Apartment $apartment, Request $request) {

    $active = $request->input('active');
    $rooms = $request->input('rooms');
    $beds = $request->input('beds');
    $lat = $request->input('lat');
    $lon = $request->input('lon');
    $rad = $request->input('rad');
    $R = 6371;
    $wifi = $request->input('wifi');
    $parking = $request->input('parking');
    $pool = $request->input('pool');
    $reception = $request->input('reception');
    $sauna = $request->input('sauna');
    $seaView = $request->input('seaView');
    $sponsors = $request->input('sponsors');
    // $silver = $request->input('silver');
    // $gold = $request->input('gold');

    $params = [
            "maxLat" => $lat + rad2deg($rad/$R),
            "minLat" => $lat - rad2deg($rad/$R),
            "maxLon" => $lon + rad2deg(asin($rad/$R) / cos(deg2rad($lat))),
            "minLon" => $lon - rad2deg(asin($rad/$R) / cos(deg2rad($lat))),
        ];

    $querySuite = Apartment::query();
    $querySuitePromo = Apartment::query();

    $querySuite->whereBetween('lat', [$params['minLat'], $params['maxLat']])->orderBy('lat', 'ASC');
    $querySuite->whereBetween('lon', [$params['minLon'], $params['maxLon']]);

    if ($wifi == 'checked') {
      $querySuite->whereHas('services', function (Builder $query) {
        $query->where('service_id', '=', '1');
      });
    }

    if ($parking == 'checked') {
      $querySuite->whereHas('services', function (Builder $query) {
        $query->where('service_id', '=', '2');
      });
    }

    if ($pool == 'checked') {
      $querySuite->whereHas('services', function (Builder $query) {
        $query->where('service_id', '=', '3');
      });
    }

    if ($reception == 'checked') {
      $querySuite->whereHas('services', function (Builder $query) {
        $query->where('service_id', '=', '4');
      });
    }

    if ($sauna == 'checked') {
      $querySuite->whereHas('services', function (Builder $query) {
        $query->where('service_id', '=', '5');
      });
    }

    if ($seaView == 'checked') {
      $querySuite->whereHas('services', function (Builder $query) {
        $query->where('service_id', '=', '6');
      });
    }

    if ($active) {
      $querySuite->where('active', "=", 1);
    }

    if ($rooms) {
      $querySuite->where('rooms', "=", $rooms);
    }

    if ($beds) {
      $querySuite->where('beds', "=", $beds);
    }

    // $querySuitePromo->whereBetween('lat', [$params['minLat'], $params['maxLat']])->orderBy('lat', 'ASC');
    // $querySuitePromo->whereBetween('lon', [$params['minLon'], $params['maxLon']]);

    if ($sponsors) {
      $querySuitePromo->whereHas('sponsorships', function (Builder $sponsor) {
        $sponsor->where('sponsorship_id', '>', '0');
      });
    }


    // if ($silver == '2') {
    //   $querySuitePromo->whereHas('sponsorships', function (Builder $saro) {
    //     $saro->where('sponsorship_id', '=', '2');
    //   });
    // }
    //
    // if ($gold == '3') {
    //   $querySuitePromo->whereHas('sponsorships', function (Builder $saro) {
    //     $saro->where('sponsorship_id', '=', '3');
    //   });
    // }

    if ($active) {
      $querySuitePromo->where('active', "=", 1);
    }

    $noPromo = $querySuite->get();
    $promo = $querySuitePromo->get();

        return response()->json(compact('noPromo', 'promo'));
  }
}
