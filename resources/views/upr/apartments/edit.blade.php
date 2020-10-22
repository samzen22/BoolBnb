@extends('layouts.app')

@section('content')
  <section class="justify-content-around cs-space">
    <div class="container">
      <h1 class="text-center mb-3">Modifica l'appartamento</h1>
      {{-- Validazione form --}}
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- modifica appartamento --}}
      <div class="card col-lg-12 bg-light">
        <form class="p-5" action="{{route('upr.apartments.update', $apartment)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

          <div class="form-line">
            <label class="col-md-3 col-form-label text-md-right" for="title">Titolo: <i class="fas fa-home ml-3 "></i></label><br>
            <input class="form-control width-form" type="text" name="title" value="{{ ($apartment->title) ? $apartment->title : old('title') }}" placeholder="Inserisci il nome dell'appartamento">
          </div>

          <div class="form-line">
            <label class="col-md-3 col-form-label text-md-right" for="description">Descrizione: <i class="far fa-file-alt ml-3"></i></label><br>
            <textarea class="form-control width-form" name="description" rows="4" cols="60" placeholder="Inserisci una breve descrizione dell'appartemento">{{ ($apartment->description) ? $apartment->description : old('description') }}</textarea>
          </div>

          <div class="form-line">
            <label class="col-md-3 col-form-label text-md-right" for="rooms">Stanze: <i class="fas fa-door-open ml-3"></i></label><br>
            <input class="form-control width-form" type="number" name="rooms" value="{{ ($apartment->rooms) ? $apartment->rooms : old('rooms') }}" placeholder="Inserisci il numero di stanze">
          </div>

          <div class="form-line">
            <label class="col-md-3 col-form-label text-md-right" for="beds">Letti: <i class="fas fa-bed ml-3"></i></label><br>
            <input class="form-control width-form" type="number" name="beds" value="{{ ($apartment->beds) ? $apartment->beds : old('beds') }}" placeholder="Inserisci il numero di letti">
          </div>

          <div class="form-line">
            <label class="col-md-3 col-form-label text-md-right" for="baths">Bagni: <i class="fas fa-bath ml-3"></i></label><br>
            <input class="form-control width-form" type="number" name="baths" value="{{ ($apartment->baths) ? $apartment->baths : old('baths') }}" placeholder="Inserisci il numero di bagni">
          </div>

          <div class="form-line">
            <label class="col-md-3 col-form-label text-md-right" for="square_meters">Metri quadri: <i class="fas fa-ruler ml-3"></i></label><br>
            <input class="form-control width-form" type="number" name="square_meters" value="{{ ($apartment->square_meters) ? $apartment->square_meters : old('square_meters') }}" placeholder="Inserisci i metri quadri">
          </div>

          <div class="form-line">
            <label class="col-md-3 col-form-label text-md-right" for="address">Indirizzo: <i class="fas fa-map-marker-alt ml-3"></i></label><br>
            <input class="form-control width-form" name="address" type="search" id="address-new" class="form-control" placeholder="Inserisci l'indirizzo" value="" required/>
          </div>

          <div>
            <input id="lat" type="hidden" name="lat">
          </div>

          <div>
            <input id="lon" type="hidden" name="lon">
          </div>

          <div>
            <input id="active" type="hidden" name="active" value='1'>
          </div>

          <div class="chekboxes form-line">
            <span class="col-md-3 col-form-label text-md-right">Servizi:</span>
            @foreach ($services as $service)
              <div class="mr-3">
                <input type="checkbox" name="services[]" value="{{ $service->id }}" {{($apartment->services->contains($service)) ? 'checked' : ''}}>
                <label>{{$service->type}}</label>
              </div>
            @endforeach
          </div>

          <div class="form-line">
            <label class="mr-4" for="image">Carica una foto dell'appartamento</label>
            <input type="file" name="image" accept="image/*" required>
          </div>

          <div class="col-md-3 col-form-label text-md-right">
            <input class="btn cs-btn mt-2" type="submit" name="" value="Salva">
          </div>
        </form>
      </div>

      <a class="btn cs-btn mt-4 float-right" href="{{ route('upr.apartments.index') }}">Torna alla lista dei tuoi appartamenti</a>

      <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

      <script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script>

      <script>
      (function() {
        var placesAutocomplete = places({
          appId: 'pl72UD0E1RWC',
          apiKey: '6f2ccdf8214af2f289be15103d07cf1c',
          container: document.querySelector('#address-new'),

        });
        var address = document.querySelector('#address-value')
        placesAutocomplete.on('change', function(e) {
          console.log(placesAutocomplete);
            $('#address-new').val(e.suggestion.value);
            $('#lat').val(e.suggestion.latlng.lat);
            $('#lon').val(e.suggestion.latlng.lng);

            console.log("latitudine: ", $('#lat').val());
            console.log("longitudine: ", $('#lon').val());
        });
      })();
      </script>
    </div>
  </section>
@endsection
