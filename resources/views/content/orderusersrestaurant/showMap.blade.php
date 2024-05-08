@extends('layouts/layoutMaster')

@section('title', 'Track Order')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/leaflet/leaflet.css')}}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/leaflet/leaflet.js')}}"></script>
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
@endsection

@section('page-style')






<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />

@endsection

@section('page-script')






@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Maps /</span> Leaflet
</h4>

<div class="row">





  <!-- User Location -->
  <div class="col-12">
    <div class="card mb-4">
      <h5 class="card-header">User Location</h5>
      <div class="card-body">
        <div id="map" style="height:50vh">



          {{-- Pusher --}}

          {{-- <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script> --}}
          <script src="https://cdn.jsdelivr.net/npm/pusher-js@8.2.0/dist/web/pusher.js"></script>

          <script>
            var map, marker;
            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('936c40e68e13d243ef67', {
              cluster: 'eu',
            });

            var channel = pusher.subscribe('deliveries');
            channel.bind('App\\Events\\DeliveryUpdatedLocation', function(data) {



              marker.setPosition( {
                  lat: Number(data.lat),
                  lng: Number(data.lng)
                });





            });

          </script>


          <script>
            console.log(  parseFloat("{{ $order->deliveryTrack->lng }}"));

            // let map;
            async function initMap() {

              const location =
              {
                lat: Number("{{ $order->deliveryTrack->lat }}"),
                lng: Number("{{ $order->deliveryTrack->lng }}")
              };



              // Request needed libraries.
              //@ts-ignore

              const { Map } = await google.maps.importLibrary("maps");
              const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

              // The map, centered at Uluru
              map = new Map(document.getElementById("map"), {
                zoom: 15,
                center: location,
                mapId: "DEMO_MAP_ID",


              });
              // The marker, positioned at Uluru
              marker = new AdvancedMarkerElement({

                map: map,
                position: location,
                title: "Uluru",
              });
            }
            window.initMap = initMap;

            // initMap();

          </script>


          <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDiA82v-YbjjXlbJ_wjJUfS902W446uCMU&loading=async&callback=initMap">
          </script>







        </div>
      </div>
    </div>
  </div>

</div>
@endsection
