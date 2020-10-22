<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Apartment;
use App\Service;
use App\User;

class ApartmentController extends Controller
{

  public function index()
  {
      $apartments = Apartment::all();

      return view('index', compact('apartments'));
  }


  public function show(Apartment $apartment) {

    $users = User::all();
    if (!empty(Auth::user())) {
      $user_auth = Auth::user();
      return view('show', compact('apartment', 'users', 'user_auth'));
    } else {
      return view('show', compact('apartment', 'users'));
    }
  }

  public function search(Request $request)
  {


    $requestInfo = $request->all();
    // dd($requestInfo['lat']);

    $apartments = Apartment::all();
    $services = Service::all();

    return view('search', [
      'apartments' => $apartments,
      'services' => $services,
      'requestInfo' => $requestInfo,
    ]);
  }
}
