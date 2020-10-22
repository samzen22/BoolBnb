@extends('layouts.app')

@section('content')
  {{-- check user auth for message --}}
  @php
  $isUserAuth = isset($user_auth);
  @endphp

  <!-- Apartment Section -->
  <section class="justify-content-around cs-apartment">

    <!-- Apartment Container -->
    <div class="container">

      <h1>{{ $apartment->title }}</h1>
      <h5><b>{{ $apartment->address }}</b></h5>

      <div class="container-apartment-show row">
        {{-- left col --}}
        <div class="card-show row col-sm-12 col-lg-9 left">
          {{-- container photo --}}
          <div class="container-photo col-sm-12">
            <div class="photo-show col-sm-12">
              <img src=" {{ asset('storage') . '/' . $apartment->image }} " alt="{{$apartment->title}}">
            </div>
          </div>
          {{-- container description room service--}}
          <div class="apartment-info col-sm-12 col-lg-8">
            <div class="row">
              {{-- description show --}}
              <div class="description-show col-sm-12">
                <h5><b>Descrizione:</b></h5>
                <div class="p-2">
                  <p>{{ $apartment->description }}</p>
                </div>
              </div>
              {{-- service --}}
              <div class="apartment-feature row col-sm-12">
                <ul class="feat-1 col-sm-12">
                  <li><b>Stanze:</b> {{ $apartment->rooms }}</li>
                  <li><b>Letti:</b> {{ $apartment->beds }}</li>
                  <li><b>Bagni:</b> {{ $apartment->baths }}</li>
                  <li><b>Metri quadri:</b> {{ $apartment->square_meters }}</li>
                  <li><b>Proprietario:</b> {{ $apartment->user->name }}</li>
                  {{-- <li><b>Prezzo:</b> {{ $apartment->price }}</li> --}}
                </ul>
                <ul class="service-1 col-sm-12">
                  <li><b>Servizi:</b>
                    @foreach ($apartment->services as $service)
                      {{ $service->type }}
                    @endforeach
                  </li>
                </ul>
              </div>
            </div>
          </div>
          {{-- end container description room service--}}

          {{-- col message contact--}}
          <div class="email-contact col-sm-12 col-lg-4">
            {{-- form message --}}
            @if ($isUserAuth === false || $user_auth->id !== $apartment->user_id)
              <div class="">
                <h5><b>Contatta il proprietario</b></h5>
                <form class="" action="{{ route('message.store' , $apartment) }}" method="post">
                  @csrf
                  @method('POST')
                  <div>
                    <input  type="hidden" name="apartment_id" value= {{ $apartment->id }}>
                  </div>
                  <div>
                    {{-- <label for="email">Email</label> --}}
                    <input id="emailMessage"  type="email" name="email" value= "{{ $isUserAuth ? $user_auth->email : '' }}" placeholder="Inserisci la mail" required>
                  </div>
                  <div>
                    {{-- <label for="content">Contenuto</label> --}}
                    <textarea id="textMessage" name="content" rows="8" cols="80" placeholder="Inserisci il messaggio" required></textarea>
                  </div>
                  <div>
                    <input class="btn cs-btn mt-2" id="sendMessage" type="submit" name="" value="Invia">
                  </div>
                </form>
                {{-- <!-- The Modal -->
                <div id="myModal" class="modal">

                  <!-- Modal content -->
                  <div class="modal-content">
                    <span class="close">&times;</span>
                    <p>Messaggio inviato</p>
                  </div>

                </div> --}}
              </div>
            @else
              @if ($user_auth->id === $apartment->user_id)
                <a class="btn cs-btn mt-2" href="{{ route('upr.message', $apartment) }}">Leggi i messaggi ricevuti</a>
              @endif
            @endif
            {{-- end form message --}}
          </div>
        </div>
        {{-- end left col --}}

        {{-- start right col --}}
        {{-- map id attach --}}
        <div id="mapid-show" class="col-sm-12 col-lg-3 map-show"></div>
        {{-- end right col --}}
      </div>

    </div>
    <!-- End Apartment Container -->



    {{-- script algolia / message --}}
    <script type="text/javascript">
      var mymap = L.map('mapid-show').setView([{{ $apartment->lat }}, {{ $apartment->lon }}], 14);
      var marker = L.marker([{{ $apartment->lat }}, {{ $apartment->lon }}]).addTo(mymap);
      marker.bindPopup("{{$apartment->title}} <br> {{ $apartment->address}}").openPopup();

      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
      // attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      maxZoom: 18,
      id: 'mapbox/streets-v11',
      tileSize: 512,
      zoomOffset: -1,
      accessToken: 'pk.eyJ1IjoiY29ycmFkb2N0IiwiYSI6ImNrZm51YmF0NDBlZTQyeW9lYmpyNGpzcGYifQ.A43eZmLSH1fCHbMCGtG_Zg'
      }).addTo(mymap);
    </script>

    <script>
    // var modal = document.getElementById("myModal");
    // var span = document.getElementsByClassName("close")[0];
      $('#sendMessage').click(function() {
        var email = $('#emailMessage').val();
        var text = $('#textMessage').val();
        if (email != '' && text != '') {
          alert('Messaggio inviato');
         // printPopUp();
        }
      });
      // function printPopUp() {
      //   modal.style.display = "block";
      // }
      // // When the user clicks on <span> (x), close the modal
      // span.onclick = function() {
      //   modal.style.display = "none";
      // }
      //
      // // When the user clicks anywhere outside of the modal, close it
      // window.onclick = function(event) {
      //   if (event.target == modal) {
      //     modal.style.display = "none";
      //   }
      // }

    </script>
  </section>
  <!-- End Apartment Section -->
@endsection
