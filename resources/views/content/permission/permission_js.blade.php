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
{{-- ///////////////////////////////to delete city ////////////////////////////// --}}






{{-- /** to fetch list of the data of countries and populate the dropdown*/// --}}
{{-- <script>
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
    $('#country_id').html(options);
  },
  error: function (response) {
    // Handle error if fetching countries fails
    console.error('Error fetching countries:', response);
  }
});


  });

</script> --}}








{{-- /** to fetch list of the data of countries and populate the dropdown in update */// --}}
{{-- <script>
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

</script> --}}





{{-- /***update Permission*// --}}

<script>
  $(document).on("click", ".close-btn", function(e) {
    $('.errMsgContainer').empty(); // Clear error messages when form is closed
});


  $(document).on("click", '.update_permission_form', function() {
    /* To retrieve the data values from the form */
    let id = $(this).data('id');
    let name = $(this).data('name');
    let guard = $(this).data('guard');

    /** To set the values for each input **/
    $('#up_id').val(id);
    $('#up_name').val(name);
    $('#guard').val(guard);


});

$(document).on("click", ".update_permission", function(e) {
    e.preventDefault();
    let id = $('#up_id').val();
    let up_name = $('#up_name').val();
    let guard = $('#guard').val();
    $('.errMsgContainer').empty(); // Clear previous error messages

    $.ajax({
        url: "{{ route('permissions.update', ['permission' => ':id']) }}".replace(':id', id),
        method: "put",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: id,
            name: up_name,
            guard: guard,
        },
        dataType: "json",
        success: function(data) {
    console.log('AJAX request successful:', data);

    if (data.status) {
      console.log(data);
        // Update successful
         $('#updatePermissionModal').modal('hide');
         $('#data-table2').load(location.href+' #data-table2');
                $('#success2').show();
                /* hide success message after 4 seconds */
                setTimeout(function() {
                    $('#success2').hide();
                }, 2000); // 2000 milliseconds = 2 seconds
    } else {
                // Update failed
                console.error('Failed to update Permission');
            }
        },
        error: function (response) {
          console.log(response);
            if (response.status === 422) {
              $('.errMsgContainer').empty(); // Clear previous error messages
                errors = response.responseJSON.errors;
                $.each(errors, function (index, value) {
                    $('.errMsgContainer').append('<span class="text-danger">' + value + '</span></br>');
                });

            } else{

              // alert('This Coupon Is Used You Cannot Update It.');
              $('#updatePermissionModal').modal('hide');
                $('#success5').show();
                /* hide success message after 4 seconds */
                setTimeout(function () {
                    $('#success5').hide();
                }, 2000); // 2000 milliseconds = 2 seconds
            }
        }
    });
});
</script>

{{-- ----------------------------------------------------------------------------------- --}}




{{-- ////////////////////////////////////////**add Permission///////////////////////////////////--}}
<script>
  $(document).ready(function(){
    $(document).on("click", '.add_permission', function(e){
        e.preventDefault();
         let name = $('#name').val();
        let guard = $('#guard').val();


        $('.errMsgContainer').empty(); // Clear previous error messages
        console.log(name);
        console.log(name);

        $.ajax({
            url: "{{ route('permissions.store') }}",
            method: 'post',
            data: {
                name: name,
                guard:guard
            },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              console.log(data);
              $('.errMsgContainer').empty(); // Clear previous error messages
              $("#addpermissionModal").modal("hide");
              $('#addPermissionForm')[0].reset();
              $('#data-table2').load(location.href+' #data-table2');
              $('#success1').show();
                /* hide success message after 4 seconds */
                setTimeout(function() {
                    $('#success1').hide();
                }, 2000); // 2000 milliseconds = 2 seconds
              $('.errMsgContainer').empty(); // Clear previous error messages

            },
            error: function(response) {
              console.log(response.responseJSON);

                $('.errMsgContainer').empty(); // Clear previous error messages
                errors = response.responseJSON.errors;
                $.each(errors, function(index, value){
                    $('.errMsgContainer').append('<span class="text-danger">'+value+'</span><br/>');
                });
            }
        });
    });
});
</script>

{{-- ---------------------------------------------------------------------------------------------------}}





{{-- //////////////////////////////DElete Permission////////////////////////////// --}}

 <script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


// Use document or a container element that is always present on the page
$(document).on('click', '.delete-permission', function (e) {
    e.preventDefault();
    var permission_id = $(this).data('id');

    if (confirm("Are you sure you want to delete this Permission?")) {
        $.ajax({
            url: 'permissions/' + permission_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                permission: permission_id
            },
            success: function (data) {
                if (data.status == true) {
                    // Permission was deleted successfully
                    $('#data-table2').load(location.href + ' #data-table2');

                    $('#success3').show();
                    /* hide success message after 4 seconds */
                    setTimeout(function () {
                        $('#success3').hide();
                    }, 2000);
                } else if (data.status == 422) {
                    // Permission could not be deleted due to relationships
                    alert('You cannot delete this Permission as it is related to other tables.');
                } else if (data.status == 403) {
                    // Permission deletion forbidden due to relationships
                    alert('Deletion of this Permission is forbidden as it is related to other tables.');
                }
            },
            error: function (data) {
                console.log(data);

                alert('You cannot delete this Permission as it is related to other tables');

            }
        });
    }
});


</script>

{{-- ---------------------------------------------------------------------------}}



{{-- /////////////////////////////Pagination Permission///////////////////////////////////// --}}
<script>
  $(document).on('click', '.pagination a', function(e){

  e.preventDefault();
  let page = $(this).attr('href').split('page=')[1];
  permission(page);
});

function permission(page) {
    $.ajax({
      url: "/pagination/paginate-permission?page=" + page,
        type: 'get',
        success: function(data) {
            $('.table-responsive').html(data);
        }
    });
}

</script>
{{-- --------------------------------------------------------------------- --}}


{{-- /////////////////////////////Search Permission///////////////////////////////////// --}}
<script>
  $(document).on('keyup',function(e){
  e.preventDefault();
  let search_string=$('#search').val();
  // console.log(search_string);
  $.ajax({
    url:"{{ route('search.permission') }}",
    method:'GET',
    data:{
      search_string:search_string
    },
    success:function(data){

      $('.table-responsive').html(data);
    }

  });



})

</script>


{{-- ------------------------------------------------------------------------------------------ --}}
