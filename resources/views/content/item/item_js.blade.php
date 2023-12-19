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








{{-- /** to fetch list of the data of countries and populate the dropdown in update */// --}}
<script>
  $(document).ready(function(){

    $.ajax({
  url: "{{ route('countries.display') }}",
  method: 'GET',
  dataType: "json",
  success: function (data) {
    // populate the dropdown with the received country data
    var options='<option value=""> Select Country </option>';
    $.each(data, function (index, country) {
     var countryName = country.translations ? country.translations[0].name : country.name;

      options += '<option value="' + country.id + '">' + countryName+ '</option>';
    });
    $('#up_country_id').html(options);
  },
  error: function (response) {
    // Handle error if fetching countries fails
    console.error('Error fetching countries:', response);
  }
});


  });

</script>






{{-- /////////////////////////////Pagination Item///////////////////////////////////// --}}



<script>
  $(document).on('click', '.pagination a', function(e){
    e.preventDefault();
    let page = $(this).attr('href').split('page=')[1];
    let storeId = window.location.pathname.split('/').pop(); 
    item(page, storeId);
  });

  function item(page, storeId) {
    $.ajax({
      url: "/pagination/paginate-storeItem/" + storeId + "?page=" + page, // Updated URL
      type: 'get',
      success: function(data) {

        $('.table-responsive').html(data);
      }
    });
  }
</script>


{{-- /////////////////////////////Pagination City///////////////////////////////////// --}}


{{-- /////////////////////////////Search City///////////////////////////////////// --}}



{{-- /////////////////////////////Search City///////////////////////////////////// --}}
