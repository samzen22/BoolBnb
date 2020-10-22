@extends('layouts.app')

@section('content')
  <section class="justify-content-around cs-space">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h1 class="text-center mb-3">Inserisci un nuovo appartamento</h1>
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
          {{-- form appartamento --}}
          <div class="card col-lg-12 bg-light">
            <form class="p-5" action="{{route('upr.apartments.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')

              <div class="form-line">
                <label class="col-md-3 col-form-label text-md-right" for="title">Titolo: <i class="fas fa-home ml-3 "></i></label><br>
                <input class="form-control width-form" type="text" name="title" value="{{ old('title')}}" placeholder="Inserisci il nome dell'appartamento" required>
              </div>

              <div class="form-line">
                <label class="col-md-3 col-form-label text-md-right" for="description">Descrizione: <i class="far fa-file-alt ml-3"></i></label><br>
                <textarea class="form-control width-form" name="description" rows="4" cols="60" placeholder="Inserisci una breve descrizione dell'appartemento" required>{{ old('description')}}</textarea>
              </div>

              <div class="form-line">
                <label class="col-md-3 col-form-label text-md-right" for="rooms">Stanze: <i class="fas fa-door-open ml-3"></i></label><br>
                <input class="form-control width-form" type="number" name="rooms" value="{{ old('rooms')}}" placeholder="Inserisci il numero di stanze" required>
              </div>

              <div class="form-line">
                <label class="col-md-3 col-form-label text-md-right" for="beds">Letti: <i class="fas fa-bed ml-3"></i></label><br>
                <input class="form-control width-form" type="number" name="beds" value="{{ old('beds')}}" placeholder="Inserisci il numero di letti" required>
              </div>

              <div class="form-line">
                <label class="col-md-3 col-form-label text-md-right" for="baths">Bagni: <i class="fas fa-bath ml-3"></i></label><br>
                <input class="form-control width-form" type="number" name="baths" value="{{ old('baths')}}" placeholder="Inserisci il numero di bagni" required>
              </div>

              <div class="form-line">
                <label class="col-md-3 col-form-label text-md-right" for="square_meters">Metri quadri: <i class="fas fa-ruler ml-3"></i></label><br>
                <input class="form-control width-form" type="number" name="square_meters" value="{{ old('square_meters')}}" placeholder="Inserisci i metri quadri" required>
              </div>

              <div class="form-line">
                <label class="col-md-3 col-form-label text-md-right" for="address">Indirizzo: <i class="fas fa-map-marker-alt ml-3"></i></label><br>
                {{-- <input type="search" name="address" class="form-control" id="address-new" placeholder="Where do you live?" /> --}}
                <input name="address" type="search" id="address-new" class="form-control" placeholder="Inserisci l'indirizzo" value="{{ old('address')}}" required/>
              </div>

              <div>
                <input id="lat" type="hidden" name="lat">
              </div>

              <div>
                <input id="lon" type="hidden" name="lon">
              </div>

              <div class="chekboxes form-line">
                <span class="col-md-3 col-form-label text-md-right">Servizi:</span>
                @foreach ($services as $service)
                  <div class="mr-3">
                    <input type="checkbox" name="services[]" value="{{ $service->id }}">
                    <label >{{$service->type}}</label>
                  </div>
                @endforeach
              </div>

              <div class="form-line">
                <label class="mr-4" for="image">Carica una foto dell'appartamento</label>
                <input type="file" name="image" accept="image/*" required>
              </div>

              <div class="col-md-3 col-form-label text-md-right">
                <input class="btn cs-btn mt-2" id="save" type="submit" name="" value="Salva">
              </div>
            </form>
          </div>

          <a class="btn cs-btn mt-4 float-right" href="{{ route('upr.apartments.index') }}">Torna alla lista dei tuoi appartamenti</a>
        </div>
      </div>
    </div>

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
  </section>
@endsection
