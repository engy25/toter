@extends('layouts.layoutMaster')

@section('title', 'City List - Pages')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
@endsection

@section('content')


<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-8">
              <button onclick="startFCM()"
                  class="btn btn-danger btn-flat">Allow notification
              </button>
          <div class="card mt-3">
              <div class="card-body">
                  @if (session('status'))
                  <div class="alert alert-success" role="alert">
                      {{ session('status') }}
                  </div>
                  @endif
                  <form action="{{ route('send.web-notification') }}" method="POST">
                      @csrf
                      <div class="form-group">
                          <label>Message Title</label>
                          <input type="text" class="form-control" name="title">
                      </div>
                      <div class="form-group">
                          <label>Message Body</label>
                          <textarea class="form-control" name="body"></textarea>
                      </div>
                      <button type="submit" class="btn btn-success btn-block">Send Notification</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>
{{-- <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script> --}}



<!-- Import  the required Firebase SDK components -->
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>



<script>
  var firebaseConfig = {
      apiKey: 'AIzaSyDjD9dHVTVYEvHf1R_hV0QyGtlLgaIHmm4',
      authDomain: 'elwada7-bf529.firebaseapp.com',
      databaseURL: 'https://project-id.firebaseio.com',
      projectId: 'elwada7-bf529',
      storageBucket: 'elwada7-bf529.appspot.com',
      messagingSenderId: '845913731989',
      appId: '1:845913731989:web:0bd366a102b4292d4bfc9c',
      measurementId: 'G-FCCWE06R5L',
  };
  firebase.initializeApp(firebaseConfig);
  const messaging = firebase.messaging();
  function startFCM() {
      messaging
          .requestPermission()
          .then(function () {
              return messaging.getToken()
          })
          .then(function (response) {
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
              $.ajax({
                  url: '{{ route("store.token") }}',
                  type: 'POST',
                  data: {
                      token: response
                  },
                  dataType: 'JSON',
                  success: function (response) {
                      alert('Token stored.');
                  },
                  error: function (error) {
                      alert(error);
                  },
              });
          }).catch(function (error) {
              alert(error);
          });
  }
  messaging.onMessage(function (payload) {
      const title = payload.notification.title;
      const options = {
          body: payload.notification.body,
          icon: payload.notification.icon,
      };
      new Notification(title, options);
  });
</script>







{!! Toastr::message() !!}



@endsection
