@extends('layouts.app')

@section('content')
  <!-- Search Section -->
<section id="jumbo" class="justify-content-around cs-search cs-hero">

    <div class="container-full layer">

      <!-- Section title -->
      <div class="title text-center height-center">
        <h1>Scopri alloggi nelle vicinanze tutti da vivere. </h1>
      </div>
      <!-- End Section title -->
      <div class="cs-input d-flex flex-row">
        <form class="container" action="{{ route('search')}}" method="post">
            @csrf
            @method('GET')
            <div class="form-group d-flex flex-row align-items-center">

                <div class="container">
                  <input type="search" id="address" name="address" placeholder="Dove vuoi andare?">
                  <input type="hidden" id="lat" name="lat" class="form-control">
                  <input type="hidden" id="lon" name="lon" class="form-control">
                </div>
                <div class="search-button">
                  <button type="submit" class="cs-btn cs-btn-search">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script>

                <script>
                    (function() {
                        var placesAutocomplete = places({
                            appId: 'pl72UD0E1RWC',
                            apiKey: '6f2ccdf8214af2f289be15103d07cf1c',
                            container: document.querySelector('#address')
                        });
                        var address = document.querySelector('#address-value')
                        placesAutocomplete.on('change', function(e) {
                          // console.log(placesAutocomplete);
                            $('#address').val(e.suggestion.value);
                            $('#lat').val(e.suggestion.latlng.lat);
                            $('#lon').val(e.suggestion.latlng.lng);

                            // console.log("latitudine: ", $('#lat').val());
                            // console.log("longitudine: ", $('#lon').val());
                        });
                        placesAutocomplete.on('clear', function() {
                            //$address.textContent = 'none';
                            $('#address').val('');
                            $('#lat').val('');
                            $('#lon').val('');
                        });
                    })();
                </script>
              </div>
          </form>
        </div>
      </div>
</section>
                  <!-- Sponsored Section -->
<section class="cs-sponsored">

  <!-- Container -->
  <div class="container-full">

    <!-- Section title -->
    <div class="title text-center">
      <h3>Appartamenti in evidenza</h3>
    </div>
    <!-- End Section title -->

    <!-- Apartments Container -->
    <div class="container-full d-xs-flex flex-column cs-apartments-container">

      <!-- First Row -->
      <div class="row justify-content-center justify-content-md-around">

        @foreach ($apartments as $apartment)
          @if (!$apartment->sponsorships->isEmpty() && $apartment->active == 1 && $apartment->sponsorships[0]->pivot->end_date > $now)


            <!-- Single Sponsored Apartment-->
            <div class="card my-3" style="width: 18rem;">
              <!-- Apartment Img -->
              <img class="card-img-top" src=" {{ asset('storage') . '/' . $apartment->image }} " alt="Apartment image">
              <!-- Apartment Text -->
              <div class="card-body d-flex flex-column">
                <h5 class="card-title text-center">{{ $apartment->title }}</h5>
                <p class="card-text">{{ $apartment->description }}</p>
                <p class="card-text">{{ $apartment->address }}</p>
                <a href="{{ route('apartments.show', $apartment) }}" class="btn cs-btn align-self-center">SCOPRI</a>
              </div>
            </div>
            <!-- End Single apartment-->
          @endif
        @endforeach

      </div>
      <!-- End First Row -->

    </div>
    <!-- End Apartment Container -->

  </div>
  <!-- End Container -->

</section>
<!-- End Sponsored Section -->
@endsection
