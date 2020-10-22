<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App Title -->
    <title>{{ config('app.name', 'BoolBnb') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/leaflet/1/leaflet.css" />

   <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js" charset="utf-8"></script>

</head>
  <body onload="searchPromo(); searchApartments();">
    <div id="app">
      <nav class="fixed-top navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
          <a class="navbar-brand" href="{{ url('/') }}">
              <img id="logo" src="{{ asset('storage/images/logo.png')}}" alt="Airbnb Logo">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
              <!-- Authentication Links -->
              @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
              @else
                <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      {{ Auth::user()->name }}
                  </a>

                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                  </div>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('upr.apartments.index') }}">Dashboard</a>
                </li>
              @endguest
            </ul>
          </div>
        </div>
      </nav>

      <main>
        <!-- Search Section -->
        <section class="justify-content-around cs-space">
          <!-- Search Container -->
          <div class="container">
            <div class="row">
              <div class="col-12">
                <div class="cs-search-input container">
                  <!-- Search Form Container-->
                  <div class="form-container">
                    <form class="container" action="" method="post">
                        @csrf
                        @method ('GET')

                      <!-- Searchbar Container-->
                      <div class="mb-3 d-flex align-items-center justify-content-between">
                        <!-- Searchbar-->
                        <div class="container">
                          {{-- <label for="address"></label> --}}
                          <input class="container cs-city" id="address" type="text" name="address" value="{{ $requestInfo['address'] }}">
                          <div class="">
                            <input id="lat" type="hidden" name="lat" value="{{ $requestInfo['lat'] }}">
                          </div>
                          <div class="">
                            <input id="lon" type="hidden" name="lon" value="{{ $requestInfo['lon'] }}">
                          </div>
                        </div>

                        <!-- Button-->
                        {{-- <div class="search-button">
                          <button class="cs-btn cs-btn-search" id="submit" type="button" name="button"><i class="fas fa-search"></i></button>
                        </div> --}}
                      </div>
                      <!-- End Searchbar Container-->


                      <!-- Filters Toggle-->
                      <span id="filters">Filtri di ricerca <i id="arrow" class="fas fa-chevron-down"></i></span>

                      <!-- Filters Section-->
                      <div class="cs-filters d-none">

                        <!-- First Row filters -->
                        <div class="row cs-rooms d-flex col-12 col-sm-6 justify-content-between">

                          <!-- Distance -->
                          <div class="col-lg-4 col-sm-12">
                            <label for="radius">Distanza:</label>
                            <select id="radius" class="" name="radius">
                              <option value="20">20km</option>
                              <option value="30">30km</option>
                              <option value="40">40km</option>
                            </select>
                          </div>

                          <!-- Rooms -->
                          <div class="col-lg-4 col-sm-12 cs-sec-input">
                            <input id="rooms" min="1" max="10" type="number" name="rooms" value="" placeholder="Inserisci le stanze">
                          </div>

                          <!-- Baths -->
                          <div class="col-lg-4 col-sm-12 cs-sec-input">
                            <input id="beds" min="1" max="10" type="number" name="beds" value="" placeholder="Inserisci i letti">
                          </div>
                        </div>
                        <!-- End First Row Filters -->

                        <!-- Second Row filters -->
                        <div class="row cs-services d-flex justify-content-between">

                          <!-- Wifi -->
                          <div class="cs-single-service">
                            <input id="wifi" type="checkbox" name="wifi" value="">
                            <label for="wifi">Wi-fi</label>
                          </div>

                          <!-- Parking -->
                          <div class="cs-single-service">
                            <input id="parking" type="checkbox" name="parking" value="">
                            <label for="parking">Parcheggio</label>
                          </div>

                          <!-- Pool -->
                          <div class="cs-single-service">
                            <input id="pool" type="checkbox" name="pool" value="">
                            <label for="pool">Piscina</label>
                          </div>

                          <!-- Reception -->
                          <div class="cs-single-service">
                            <input id="reception" type="checkbox" name="reception" value="">
                            <label for="reception">Portineria</label>
                          </div>

                          <!-- Sauna -->
                          <div class="cs-single-service">
                            <input id="sauna" type="checkbox" name="sauna" value="">
                            <label for="sauna">Sauna</label>
                          </div>

                          <!-- Sea View -->
                          <div class="cs-single-service">
                            <input id="seaView" type="checkbox" name="seaView" value="">
                            <label for="seaView">Vista mare</label>
                          </div>
                        </div>
                        <!-- End Second Row filters -->

                      </div>
                      <!-- End Filters Section-->
                    </form>
                  </div>
                  <!-- End Search Form Container-->
                </div>
              </div>
            </div>
          </div>
          <!-- End Search Container -->
        </section>
        <!-- End Search Section -->

        <!-- Apartment Promo Section -->
        <section>
          <div class="container-full cs-search-promo">
            <div class="row">
              <div class="col-12">

                <!-- Search Result Container -->
                <!-- >> Handlebars will print its template here -->
                <div id="apartment_list_promo">

                </div>
                <!-- End Search Result Container -->
              </div>
            </div>
          </div>
        </section>
        <!-- End Apartment Promo Section -->

        <!-- Apartment Result Section -->
        <section>
          <div class="container">
            <div class="row">
              <div class="col-lg-4 col-sm-12">
                <!-- Search Result Container -->
                <!-- >> Handlebars will print its template here -->
                <div id="apartment_list"></div>
                <!-- End Search Result Container -->
              </div>
              <div class="col-lg-8 col-sm-12">
                <div class="containerMap">
                  <!-- Map Container -->
                  <div id="mapid"></div>
                  <!-- End Map Container --></div>
              </div>
            </div>
          </div>
        </section>
        <!-- End Apartment Result Section -->

        <!-- Map Section -->
        {{-- <section>
          <div class="container">
            <div class="row">

            </div>
          </div>
        </section> --}}
        <!-- End Apartment Result Section -->
      </main>
      @include('layouts.partials.footer')
    </div>

    {{-- JS --}}

    {{-- Script places --}}
    <script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script>

    <script>
    (function() {
          var placesAutocomplete = places({
            appId: 'pl72UD0E1RWC',
            apiKey: '6f2ccdf8214af2f289be15103d07cf1c',
            container: document.querySelector('#address'),
          });
          var $address = document.querySelector('#address');
            placesAutocomplete.on('change', function(e) {
              document.querySelector("#address").value = e.suggestion.value || "";
              document.querySelector("#lat").value = e.suggestion.latlng.lat || "";
              document.querySelector("#lon").value = e.suggestion.latlng.lng || "";
            });
            placesAutocomplete.on('clear', function() {
              $address.textContent = 'none';
            });
        })();
    </script>
    {{-- End Script places --}}

    {{-- Script Handlebars --}}
    <script id="apartment-template" type="text/x-handlebars-template">
      <!-- Apartment Card -->
      <div class="card my-3" style="width: 18rem;">
        <!-- Apartment Image -->
        <img class="card-img-top" src=" {{ asset('storage') . '/'}}@{{{image}}} " alt="Apartment image">
        <!-- Apartment Infos -->
        <div class="card-body d-flex flex-column">
          <!-- Apartment Title -->
          <h5 class="card-title text-center">@{{ title }}</h5>
          <!-- Apartment Description -->
          <p class="card-text">@{{ description }}</p>
          <!-- Apartment Address -->
          <p class="card-text">@{{ address }}</p>
          <!-- Apartment Btn -->
          <a href="/apartments/@{{ id }}" class="btn cs-btn align-self-center">SCOPRI</a>
        </div>
      </div>
      <!-- End Apartment Card -->
    </script>
    {{-- End Script Handlebars --}}

    {{-- Chiamata Ajax per API --}}
    <script>
    $( "#radius" ).change(function() {
      searchApartments();
    });

    $(document).ready(function() {
      $( "input" ).change(function() {
      searchApartments();
    });
       $("#filters").click(function(){
         $(".cs-filters").toggleClass("d-none");
       })
    });

    // $(document).ready(function() {
    //   $('#submit').click(function() {
    //     searchApartments();
    //    });
    // });

    function searchPromo() {
      var sponsors = 1;
      var active = 1;

      $.ajax(
       {
         url: 'http://127.0.0.1:8000/api/search',
         method: 'GET',
         data: {
           sponsors: sponsors,
           active: active,
         },
         success: function(dataResponse) {
           printHandlebarsPromo(dataResponse);
         },
         error: function() {
           alert('error');
         }
       }
     );
    }

    function searchApartments() {
      var active = 1;
      var lat = $('#lat').val();
      var lon = $('#lon').val();
      var rad = $( "select#radius option:checked" ).val();
      var rooms = $('#rooms').val();
      var beds = $('#beds').val();
      var wifi = $('#wifi').is(":checked") ? wifi = 'checked' : wifi = 'unchecked';;
      var parking = $('#parking').is(":checked") ? parking = 'checked' : parking = 'unchecked';
      var pool = $('#pool').is(":checked") ? pool = 'checked' : pool = 'unchecked';
      var reception = $('#reception').is(":checked") ? reception = 'checked' : reception = 'unchecked';
      var sauna = $('#sauna').is(":checked") ? sauna = 'checked' : sauna = 'unchecked';
      var seaView = $('#seaView').is(":checked") ? seaView = 'checked' : seaView = 'unchecked';
      // console.log(lat);
      // console.log(lon);
      // console.log(rad);
      // console.log(rooms);
      // console.log(beds);
      // console.log(wifi);
      // console.log(parking);
      // console.log(pool);
      // console.log(reception);
      // console.log(sauna);
      // console.log(seaView);

        $.ajax(
         {
           url: 'http://127.0.0.1:8000/api/search',
           method: 'GET',
           data: {
             active: active,
             lat: lat,
             lon: lon,
             rad: rad,
             rooms: rooms,
             beds: beds,
             wifi: wifi,
             parking: parking,
             pool: pool,
             reception: reception,
             sauna: sauna,
             seaView: seaView,
           },
           success: function(dataResponse) {
             printHandlebars(dataResponse);
             $('#mapid').remove();
             $('.containerMap').html('<div id="mapid"></div>');
             printMap(dataResponse);
           },
           error: function() {
             alert('error');
           }
         }
       );
      }
    </script>
    {{-- End chiamata Ajax per API --}}


    <script>
      function printHandlebars(dataResponse) {
        // console.log(dataResponse);
        $('#apartment_list').html('');

        var allApartments = dataResponse.noPromo;

        var source = $("#apartment-template").html();
        var template = Handlebars.compile(source);

        if (allApartments.length != 0) {
          for (var i = 0; i < allApartments.length; i++) {
            var thisApartment = allApartments[i];

            var html = template(thisApartment);
            $('#apartment_list').append(html);
          }
        } else {
          $('#apartment_list').html('<h2>Non ci sono appartamenti corrispondenti alla ricerca</h2>');
        }
      }

      function printHandlebarsPromo(dataResponse) {
        // console.log(dataResponse);
        $('#apartment_list_promo').html('');

        var allApartments = dataResponse.promo;

        var source = $("#apartment-template").html();
        var template = Handlebars.compile(source);

        if (allApartments.length != 0) {
          for (var i = 0; i < allApartments.length; i++) {
            var thisApartment = allApartments[i];

            var html = template(thisApartment);
            $('#apartment_list_promo').append(html);
          }
        }
      }
    </script>


    {{-- Script per mappa --}}
    <script>

    function printMap(dataResponse) {
      var latitude = $('#lat').val();
      var longitude = $('#lon').val();
      var mymap = L.map('mapid').setView([latitude, longitude], 10);
      var data = dataResponse.noPromo;
      // console.log(data);
      for (var i = 0; i < data.length; i++) {
        var thisMarker = data[i];
        var marker = L.marker([ thisMarker.lat  ,   thisMarker.lon  ]).addTo(mymap);
        marker.bindPopup(thisMarker.title + '<br>' + thisMarker.address);
      }

      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
      // attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      maxZoom: 18,
      id: 'mapbox/streets-v11',
      tileSize: 512,
      zoomOffset: -1,
      accessToken: 'pk.eyJ1IjoiY29ycmFkb2N0IiwiYSI6ImNrZm51YmF0NDBlZTQyeW9lYmpyNGpzcGYifQ.A43eZmLSH1fCHbMCGtG_Zg'
      }).addTo(mymap);
    }


    </script>
    {{-- End Script per mappa --}}

  </body>
</html>
