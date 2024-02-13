<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<!-- CSS files -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr JS -->
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>




<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>



{{-- show the map of the track order --}}


{{-- /////////////////////////////Pagination OrderCallCenter///////////////////////////////////// --}}
<script>
  $(document).on('click', '.pagination a', function(e){

  e.preventDefault();
  let page = $(this).attr('href').split('page=')[1];
  order(page);
});

function order(page) {
    $.ajax({
      url: "/pagination/paginate-orderstore?page=" + page,
        type: 'get',
        success: function(data) {
          console.log(data);
            $('.table-responsive').html(data);
        },error:function(response){
          console.log(response);
        }
    });
}

</script>
{{-- ////////////////////////////////////////////////////////////////// --}}



{{-- /////////////////////////////Search Order///////////////////////////////////// --}}
<script>
  function performSearch() {
    let search_string = $('#search').val();
    let deliveryId = $('#delivery').val();
    let date = $('#date').val();
    let status =$('#status').val();



    $.ajax({
      url: "/search-orderstore/",
      method: 'GET',
      data: {
        search_string: search_string,
        deliveryId: deliveryId,
        date: date,
        status:status
      },
      success: function (data) {

        $('.table-responsive').html(data);
      },
      error: function (response) {
        console.log(response);
      }
    });
  }

  $(document).on('keyup', function (e) {

    performSearch();
  });

  $('#delivery').change(function () {

    performSearch();
  });

  $('#status').change(function () {

    performSearch();
  });

  $('#date').change(function () {

    performSearch();
  });
</script>



{{-- /////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
