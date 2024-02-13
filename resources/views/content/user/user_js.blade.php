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





{{-- /** to fetch list of the data of tags and populate the dropdown*/// --}}
<script>
  $(document).ready(function(){
    $('#role').change(function () {
      let id = $(this).val();

      if (id) {
        $.ajax({
          url: "{{ route('permissions.list', ['roleId' => ':id']) }}".replace(':id', id),
          method: 'GET',
          dataType: "json",
          success: function (data) {
            console.log(data);
            // populate the dropdown with the received tag data
            var options = '<option value=""> Select Permission </option>';
            $.each(data, function (index, permission) {
              var permissionName = permission.name;
              options += '<option value="' + permission.id + '">' + permissionName + '</option>';
            });
            $('#permissions').html(options);
          },
          error: function (response) {
            // Handle error if fetching tags fails
            console.error('Error fetching Permission:', response);
          }
        });
      }
    });
  });
</script>







{{--Fetch The Districts Depends on City --}}


<script>
  $(document).ready(function() {
    $('#city_id').change(function() {
      var cityId = $(this).val();

      // Make an AJAX request to fetch districts for the selected city
      $.ajax({
        url: '/cities/districts/' + cityId,
        type: 'GET',
        success: function (data) {
          // Populate the district dropdown with the received data
          var options = '<option value="">Select District</option>';

          $.each(data, function (index, district) {
            var districtName = district.translations.length > 0 ? district.translations[0].name : district.name;
            options += '<option value="' + district.id + '">' + districtName + '</option>';
          });
          $('#district_id').html(options);
        },
        error: function (response) {
          console.error('Error fetching districts:', response);
        }
      });
    });

    // // Function to fetch districts from the API using Fetch API
    // function fetchDistricts() {
    //   fetch('http://your-api-endpoint/cities/districts/18')
    //     .then(response => response.json())
    //     .then(data => {
    //       // Assign the fetched districts to the global variable
    //       apiDistricts = data;
    //     })
    //     .catch(error => {
    //       console.error('Error fetching districts:', error);
    //     });
    // }

    // // Call fetchDistricts to populate apiDistricts
    // fetchDistricts();
  });



</script>










{{-- //////////////////////////////DElete Delivery////////////////////////////// --}}
{{--
<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Use document or a container element that is always present on the page
$(document).on('click', '.delete-store', function (e) {
    e.preventDefault();
    var store_id = $(this).data('id');

    if (confirm("Are you sure you want to delete this store?")) {
        $.ajax({
            url: 'stores/' + store_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                store: store_id
            },
            success: function (data) {
                if (data.status == true) {
                    // store was deleted successfully
                    $('#data-table2').load(location.href + ' #data-table2');

                    $('#success3').show();
                    /* hide success message after 4 seconds */
                    setTimeout(function () {
                        $('#success3').hide();
                    }, 2000);
                } else if (data.status == 422) {
                    // City could not be deleted due to relationships
                    alert('You cannot delete this store as it is related to other tables.');
                } else if (data.status == 403) {
                    // City deletion forbidden due to relationships
                    alert('Deletion of this store is forbidden as it is related to other tables.');
                }
            },
            error: function (data) {
                console.log(data);
                if (data.status !== 500) {
                    alert('An error occurred while deleting the store.');
                }
            }
        });
    }
});


</script> --}}

{{-- //////////////////////////////////////////////////////////// --}}



{{-- /////////////////////////////Pagination Delivery///////////////////////////////////// --}}
<script>
  $(document).on('click', '.pagination a', function(e){

  e.preventDefault();
  let page = $(this).attr('href').split('page=')[1];
  user(page);

});

function user(page) {
    $.ajax({
      url: "/pagination/paginate-alluser/"  + "?page=" + page, // Updated URL
        type: 'get',
        success: function(data) {
            $('.table-responsive').html(data);
        }
    });
}

</script>
{{-- ////////////////////////////////////////////////////////////////// --}}


{{-- /////////////////////////////Search User///////////////////////////////////// --}}
<script>
  function performSearch() {
    let search_string = $('#search').val();
    let role = $('#role').val();
    let status = $("#status").val();


    $.ajax({
      url: "/search-alluser/",
      method: 'GET',
      data: {
        search_string: search_string,
        role: role,
        status: status
      },
      success: function (data) {
        console.log(data);
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

  $('#role').change(function () {

    performSearch();
  });

  $('#status').change(function () {

    performSearch();
  });
</script>



{{-- /////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
