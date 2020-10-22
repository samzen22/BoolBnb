require('./bootstrap');

var $ = require('jquery');

var Handlebars = require("handlebars");

// $(document).ready(function() {
//   $('#submit').click(function() {
//     searchApartments();
//    });
//
//
// });
//
// function searchApartments() {
//   var lat = $('#lat').val();
//   var lon = $('#lon').val();
//   var rad = $( "select#radius option:checked" ).val();
//   console.log(lat);
//   console.log(lon);
//   console.log(rad);
//
//     // var rooms = $('#rooms').val();
//     // var beds = $('#beds').val();
//     $.ajax(
//        {
//          url: 'http://127.0.0.1:8000/api/search',
//          method: 'GET',
//          data: {
//            lat: lat,
//            lon: lon,
//            rad: rad,
//          },
//          success: function(dataResponse) {
//            console.log(dataResponse);
//            $('#apartment_list').html('');
//
//            var allApartments = dataResponse.apartments;
//            console.log(allApartments.length);
//
//            var source = $("#apartment-template").html();
//            console.log(source);
//            var template = Handlebars.compile(source);
//
//            for (var i = 0; i < allApartments.length; i++) {
//              var thisApartment = allApartments[i];
//
//              var html = template(thisApartment);
//              $('#apartment_list').append(html);
//            }
//          },
//          error: function() {
//            alert('error');
//          }
//        }
//      );
//
//   }
