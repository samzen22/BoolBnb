@extends('layouts.app')
@section('content')
  <style media="screen">

.content-container {
  background-color:#fff;
  padding:35px 20px;
  margin-bottom:20px;
}
h1.content-title{
  font-size:32px;
  font-weight:300;
  margin-top:0;
  margin-bottom:20px;
}
ul.mail-list{
  padding:0;
  margin:0;
  list-style:none;
  margin-top:30px;
}
ul.mail-list li a{
  display:block;
  border-bottom:1px dotted #CFCFCF;
  padding:20px;
  text-decoration:none;
}
ul.mail-list li:last-child a{
  border-bottom:none;
}
ul.mail-list li a:hover{
  background-color:#FF834E;
}
ul.mail-list li span{
  display:block;
}
ul.mail-list li span.mail-sender{
  font-weight:600;
  color:#8F8F8F;
}
</style>

  <section class="justify-content-around">
      <div class="container">
           <div class="content-container clearfix">
             <div class="col-md-12">
               <span class="float-right" >{{$apartment->title}}</span>
             </div>
               <div class="mt-5 col-md-12">
                   <h1 class="content-title text-center">Messaggi Ricevuti</h1>
                   <ul class="mail-list" id="containerMessageList">
                     @foreach ($messages as $message)

                       @if ($apartment->id == $message->apartment_id)
                         <li id="messagesList">
                             <a href="">
                                 <span class="mail-sender">Da: {{ $message->email }}</span>
                                 <span class="mail-message">{{ $message->content }}</span>
                             </a>
                         </li>
                       @endif
                     @endforeach
                   </ul>
               </div>

           </div>
           <a class="mb-5 btn cs-btn align-self-center" href="{{ route('upr.apartments.index') }}">Torna indietro</a>
  </section>

  <script>
  $(document).ready(function() {
    if (!$('#messagesList').length) {
      $('#containerMessageList').html("<h4 class=\"content-title text-center\">Non hai messaggi per questo appartamento.</h4>");
    };
  });
  </script>
@endsection
