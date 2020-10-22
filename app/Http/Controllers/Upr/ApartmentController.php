<?php

namespace App\Http\Controllers\Upr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Apartment;
use App\User;
use App\Service;
use App\Message;
use App\Sponsorship;
use Carbon\Carbon;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::all();
        $user = Auth::user();
        // dd('sono dentro appartamenti upr');
        return view('upr.apartments.index', compact('apartments', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $apartments = Apartment::all();
      $services = Service::all();

      return view('upr.apartments.create', compact('apartments', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
          abort('404');
        }

        // Validazione
        $request->validate($this->validationData());

        $request_data = $request->all();
        // dd($request_data);



        // Nuova istanza Appartamento
        $newApartment = new Apartment();
        $newApartment->user_id = Auth::id();
        $newApartment->fill($request_data);

        // dd($newApartment->user_id);

        if (isset($request_data['image'])) {
          $path = $request->file('image')->store('images', 'public');
          $newApartment->image = $path;
        } else {
          $newApartment->image = '';
        }
        $newApartment->save();


        if (isset($request_data['services'])) {
          $newApartment->services()->sync($request_data['services']);
        }

        // Mail::to($new_post->user->email)->send(new PostCreatedMail());

        return redirect()->route('upr.apartments.show', $newApartment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
      $users = User::all();
      $services = Service::all();
      $user_auth = Auth::user();
      $sponsorships = Sponsorship::all();
      $now = Carbon::now('Europe/Rome');
      // dd($users)
      return view('upr.apartments.show', compact('apartment', 'users', 'services', 'user_auth', 'sponsorships', 'now'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
      $user_auth = Auth::user();
      $services = Service::all();

      if ($user_auth->id !== $apartment->user_id) {
        abort('404');
      }

      return view('upr.apartments.edit', compact('apartment', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
      if (!Auth::check()) {
      abort('404');
    }

    // Validazione
    $request->validate($this->validationData());

    $request_data = $request->all();

    if (isset($request_data['services'])) {
      $apartment->services()->sync($request_data['services']);
    } else {
      $apartment->services()->detach();
    }

    if (isset($request_data['image'])) {
      $path = $request->file('image')->store('images', 'public');
      $request_data['image'] = $path;
    } else {
      $request_data['image'] = '';
    }
    $apartment->update($request_data);

    $apartment->save();



    return redirect()->route('upr.apartments.show', $apartment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
      $apartment->services()->detach();
      $apartment->sponsorships()->detach();
      $apartment->delete();
       // Mail::to($post->user->email)->send(new PostDeletedMail());
       return redirect()->route('upr.apartments.index');
    }

    public function message(Apartment $apartment)
    {
      $user = Auth::user();
      $messages = Message::all();

      return view('upr.messages.index', compact('user', 'messages', 'apartment'));
    }

    public function sospend(Request $request, Apartment $apartment)
    {
      if (!Auth::check()) {
      abort('404');
    }
      $request_data = $request['active'];

      $apartment->update(['active' => $request_data]);

      return redirect()->route('upr.apartments.index', compact('apartment'));
    }

    public function sponsorship(Request $request, Apartment $apartment)
    {
      if (!Auth::check()) {
        abort('404');
      }

      // Validazione
      $request->validate($this->validationSponsorship());


      $request_data = $request->all();
      $sponsor_id = $request_data['sponsorships'];
      $apart_id = $apartment->id;
      $start_date = Carbon::now('Europe/Rome');
      $now = Carbon::now('Europe/Rome');

      if ($sponsor_id == 1) {
        $end_date = $now->add(1, 'day');
      } elseif ($sponsor_id == 2) {
        $end_date = $now->add(3, 'day');
      } elseif ($sponsor_id == 3) {
        $end_date = $now->add(6, 'day');
      }

      if (isset($request_data['sponsorships'])) {
        $insertData=DB::table('apartment_sponsorship')
          ->insert(['start_date' => $start_date, 'apartment_id' => $apart_id, 'sponsorship_id' => $sponsor_id, 'end_date' => $end_date]);
      }

      return redirect()->route('upr.apartments.show', $apartment);
    }

    public function validationData() {
       return [
         'title' => 'required|max:255',
         'description' => 'required|max:1000',
         'rooms' => 'required|numeric|min:1|max:10',
         'beds' => 'required|numeric|min:1|max:10',
         'baths' => 'required|numeric|min:1|max:10',
         'square_meters' => 'required|numeric|min:50|max:350',
         'address' => 'required|max:400',
         'image' => 'image',
         'services' => 'required',
       ];
     }

     public function validationSponsorship() {
        return [
          'sponsorships' => 'required',
        ];
      }
}
