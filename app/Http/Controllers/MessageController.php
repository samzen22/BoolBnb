<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartment;
use App\User;
use App\Message;


class MessageController extends Controller
{

  public function store(Request $request, Apartment $apartment)
  {
    $newMessage = new Message();
    $newMessage->email = $request['email'];
    $newMessage->content = $request['content'];
    $newMessage->apartment_id = $request['aparment'];
    $newMessage->save();

    return redirect()->route('apartments.show', $request['aparment']);
  }
}
