@extends('layouts.app')

@section('content')
  <section class="justify-content-around cs-space">
    <div class="container d-flex flex-column">
      <h4 class="mb-3 text-center">I tuoi appartamenti</h4>

      <a class="mb-5 btn cs-btn align-self-center" href="{{ route('upr.apartments.create') }}">Crea un nuovo appartamento</a>

      <a class="mb-5 btn cs-btn align-self-center" href="/">Vai all' Homepage</a>

      <div class="d-xs-flex flex-column cs-apartments-container">
        <div class="row justify-content-center justify-content-md-between">
          @foreach ($apartments as $apartment)
            @if ($user->id == $apartment->user_id)
              <!-- Apartment Card -->
              <div class="card my-3" style="width: 20rem;">

                    <!-- Apartment Img -->
                    <img class="card-img-top" src="{{ asset('storage') . '/' . $apartment->image }} " alt="{{$apartment->title}}">

                    <!-- Apartment Text -->
                    <div class="card-body d-flex flex-column">

                      <!-- Apartment Title -->
                      <h5 class="card-title text-center text-uppercase"><a href="{{route('upr.apartments.show', $apartment)}}">{{$apartment->title}}</a></h5>

                      <!-- Apartment Desc -->
                      <p class="card-text text-truncate">{{$apartment->description}}</p>

                      <!-- Apartment Adress -->
                      <p class="cs-address text-truncate font-italic"><i class="mr-2 fas fa-map-marker-alt"></i>{{$apartment->address}}</p>

                      <!-- Apartment Specs -->
                      <div class="cs-apartment-specs d-flex justify-content-between">

                        @if ($apartment->beds == 1)
                          <p class="card-text">{{$apartment->beds}} Letto </p>
                        @else
                          <p class="card-text">{{$apartment->beds}} Letti </p>
                        @endif


                        <span>&middot;</span>

                        @if ($apartment->rooms == 1)
                          <p class="card-text">{{$apartment->rooms}} Camera </p>
                        @else
                          <p class="card-text">{{$apartment->rooms}} Camere </p>
                        @endif

                        <span>&middot;</span>

                        @if ($apartment->baths == 1)
                          <p class="card-text">{{$apartment->baths}} Bagno </p>
                        @else
                          <p class="card-text">{{$apartment->baths}} Bagni </p>
                        @endif

                      </div>

                      <!-- Apartment Actions -->
                      <div class="d-flex flex-column justify-content-around text-center">
                        <div class="row">
                          <div class="new-margin col-sm-12 col-lg-6">
                            <!-- Stop Button -->
                            <form class="sospend" action="{{ route('upr.sospend', $apartment) }}" method="post">
                            @csrf
                            @method('PUT')
                              <input id="sospendValue" type="hidden" name="active" value="{{ ($apartment->active == 0) ? 1 : 0  }}">
                              <input class="btn cs-btn" id="sospendButton" type="submit" value="{{ ($apartment->active == 0) ? 'Attiva' : 'Sospendi' }}">
                            </form>

                            <!-- Message Button -->
                            <a class="btn cs-btn mt-2" href="{{ route('upr.message', $apartment) }}">Messaggi</a>
                          </div>
                          <div class="col-sm-12 col-lg-6">
                            <!-- Edit Button -->
                            <a class="btn cs-btn" href="{{ route('upr.apartments.edit', $apartment) }}" >Modifica</a>

                            <!-- Delete Button -->
                            <form class="delete" action="{{ route('upr.apartments.destroy', $apartment) }}" method="post">
                            @csrf
                            @method('DELETE')
                              <input class="btn cs-btn cs-btn-delete mt-2" type="submit" value="Elimina">
                            </form>
                          </div>
                        </div>

                      </div>
                      <!-- End Apartment Actions -->
                    </div>
                  </div>
              <!-- End Apartment Card -->
            @endif
          @endforeach
        </div>
      </div>
    </div>
  </section>
@endsection
