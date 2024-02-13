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





          <script>
            let map;
            async function initMap() {

              // The location of Delivery


              const location =
              {

                lat: parseFloat("{{ $order->deliveryTrack->lat }}"),
                lng: parseFloat("{{ $order->deliveryTrack->lng }}")
              };



              // Request needed libraries.
              //@ts-ignore

              const { Map } = await google.maps.importLibrary("maps");
              const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

              // The map, centered at Uluru
              m = new Map(document.getElementById("map"), {
                zoom: 15,
                center: location,
                mapId: "DEMO_MAP_ID",


              });
              // The marker, positioned at Uluru
              const marker = new AdvancedMarkerElement({
                map: m,
                position: location,
                title: "Uluru",
              });
            }
            window.initMap = initMap;

            // initMap();

          </script>


          <script async
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlRyjrVDFE3Ry_wivw70bqbH6VYccL9n0&loading=async&callback=initMap">
          </script>


          <script src="/js/mapInput.js"></script>




        </div>
      </div>
    </div>
  </div>

</div>
@endsection
