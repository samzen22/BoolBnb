@extends('layouts.app')

@section('content')

  {{-- start section --}}
  <section class="justify-content-around cs-space">
    <div class="container">
      {{-- sponsorship --}}
      <div id="sponsor" class="container card-show upr p-3">
        @if ($apartment->sponsorships->isEmpty() || $apartment->sponsorships[0]->pivot->end_date < $now)
          <h2 class="text-center">Rendi il tuo annuncio più visibile</h2>
          <div class="sponsor">
            <div class="box">
              <form id="sponsor_form" class="row" action="{{ route('upr.sponsorship', $apartment) }}" method="post">
                @csrf
                @method ('POST')
                <div class="chekboxes col-lg-6 col-sm-12">
                  <input id="controll" type="hidden" name="controll" value="" required>
                  <h5><b>Pacchetti:</b></h5>
                  @foreach ($sponsorships as $sponsorship)
                    <div>
                      <input type="radio" name="sponsorships" value="{{ $sponsorship->id }}" required checked>
                      <label class="payment-check"><b>{{$sponsorship->name}} - {{ $sponsorship->price }} € - {{ $sponsorship->duration }} ore</b></label>
                    </div>
                  @endforeach
                </div>
                <div class="col-lg-6 col-sm-12">
                  <div id="dropin-container"></div>
                  {{-- <button type="submit" name="button">Sponsorizza</button> --}}
                </div>

              </form>
              <button class="col text-center btn cs-btn" id="submit-button">Procedi con il pagamento</button>
            </div>
          </div>
          {{-- <div class="col-6 payments">
            <div id="dropin-container"></div>
            <button id="submit-button">Request payment method</button>
          </div> --}}
          @else
          <div class="col-12">
            <h2>Appartamento sponsorizzato</h2>
            <h3>Pacchetto scelto: {{ $apartment->sponsorships[0]->name }}</h3>
          </div>
        @endif
      </div>
      {{-- end sponsorship --}}

      {{-- apartment show --}}
      <div class="my-apartment">
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
                        <span class="mr-2">{{ $service->type }}</span>
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
              @if ($user_auth->id  !== $apartment->user_id)
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
                      <input id="emailMessage"  type="email" name="email" value= "{{ $user_auth->email }}" placeholder="Inserisci la mail" required>
                    </div>
                    <div>
                      {{-- <label for="content">Contenuto</label> --}}
                      <textarea id="textMessage" name="content" rows="8" cols="80" placeholder="Inserisci il messaggio" required></textarea>
                    </div>
                    <div>
                      <input class="btn cs-btn mt-2" id="sendMessage" type="submit" name="" value="Invia">
                    </div>
                  </form>
                </div>
              @else
                <a class="btn cs-btn mt-2" href="{{ route('upr.message', $apartment) }}">Leggi i messaggi ricevuti</a>
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
      <div class="row">
        <div class="col-lg-6 col-sm-12">
          <canvas id="myChart"></canvas>
        </div>
      </div>
      <a  class="btn cs-btn mt-2" href="{{ route('upr.apartments.index') }}">Torna ai tuoi appartamenti</a>
    </div>
  </section>
  {{-- end section --}}

  {{-- script algolia / message --}}
  <script>
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
  var button = document.querySelector('#submit-button');
    braintree.dropin.create({
      authorization: "{{ 'sandbox_jy53jcts_tvwv7hhb2mh8pyqf' }}",
      container: '#dropin-container'
    },
    function (createErr, instance) {
      $('#submit-button').on('click', function () {
        instance.requestPaymentMethod(function (err, payload) {
          $.get('{{ route('upr.payment.make') }}', {payload}, function (response) {
            if (response.success) {
              $("#sponsor_form").submit();
            } else {
              alert('Payment failed');
            }
          },
          'json');
        });
      });
    });
  </script>

  <?php
   $handle = fopen("counter.txt", "r");
   if(!$handle){
     echo "could not open the file";
    } else {
      $counter = ( int ) fread ($handle,20);
      fclose ($handle);
      $counter++;
      $handle = fopen("counter.txt", "w" );
      fwrite($handle,$counter);
      fclose ($handle);
      json_encode($counter);
    }
  ?>

  <script>
  $(document).ready(function () {
    var pie = [{ value: parseInt(<?PHP echo $counter ?>) }]
    var visit = pie[0]['value'];
    showGraph(visit);
  });

  function showGraph(visit) {
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
          datasets: [{
              label: 'Visit',
              data: [0, visit],
          }],
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'September', 'October', 'November', 'December']
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      suggestedMin: 10,
                      suggestedMax: 100
                  }
              }]
          }
      }
    });
  }

  </script>
@endsection
