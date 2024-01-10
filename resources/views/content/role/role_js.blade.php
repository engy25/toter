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









{{-- /***update Role*// --}}

<script>
  $(document).on("click", ".close-btn", function(e) {
    $('.errMsgContainer').empty(); // Clear error messages when form is closed
});


  $(document).on("click", '.update_role_form', function() {
    /* To retrieve the data values from the form */
    let id = $(this).data('id');
    let name = $(this).data('name');
    let guard = $(this).data('guard');

    /** To set the values for each input **/
    $('#up_id').val(id);
    $('#up_name').val(name);
    $('#guard').val(guard);


});

$(document).on("click", ".update_role", function(e) {
    e.preventDefault();
    let id = $('#up_id').val();
    let up_name = $('#up_name').val();
    let guard = $('#guard').val();
    $('.errMsgContainer').empty(); // Clear previous error messages

    $.ajax({
        url: "{{ route('roles.update', ['role' => ':id']) }}".replace(':id', id),
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
         $('#updateRoleModal').modal('hide');
         $('#data-table2').load(location.href+' #data-table2');
                $('#success2').show();
                /* hide success message after 4 seconds */
                setTimeout(function() {
                    $('#success2').hide();
                }, 2000); // 2000 milliseconds = 2 seconds
    } else {
                // Update failed
                console.error('Failed to update Role');
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
              $('#updateRoleModal').modal('hide');
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
    $(document).on("click", '.add_role', function(e){
        e.preventDefault();
         let name = $('#name').val();
         let guard = $('#guard').val();


        $('.errMsgContainer').empty(); // Clear previous error messages
        console.log(name);
        console.log(name);

        $.ajax({
            url: "{{ route('roles.store') }}",
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
              $("#addRoleModal").modal("hide");
              $('#addRoleForm')[0].reset();
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
$(document).on('click', '.delete-role', function (e) {
    e.preventDefault();
    var role_id = $(this).data('id');

    if (confirm("Are you sure you want to delete this Role?")) {
        $.ajax({
            url: 'roles/' + role_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                role: role_id
            },
            success: function (data) {
                if (data.status == true) {
                    // Role was deleted successfully
                    $('#data-table2').load(location.href + ' #data-table2');

                    $('#success3').show();
                    /* hide success message after 4 seconds */
                    setTimeout(function () {
                        $('#success3').hide();
                    }, 2000);
                } else if (data.status == 422) {
                    // Role could not be deleted due to relationships
                    alert('You cannot delete this Role as it is related to other tables.');
                } else if (data.status == 403) {
                    // Role deletion forbidden due to relationships
                    alert('Deletion of this Role is forbidden as it is related to other tables.');
                }
            },
            error: function (data) {
                console.log(data);

                alert('You cannot delete this Role as it is related to other tables');

            }
        });
    }
});


</script>

{{-- ---------------------------------------------------------------------------}}



{{-- /////////////////////////////Pagination Role///////////////////////////////////// --}}
<script>
  $(document).on('click', '.pagination a', function(e){

  e.preventDefault();
  let page = $(this).attr('href').split('page=')[1];
  role(page);
});

function role(page) {
    $.ajax({
      url: "/pagination/paginate-role?page=" + page,
        type: 'get',
        success: function(data) {
            $('.table-responsive').html(data);
        },
        error:function(response){
          console.log(response);
        }
    });
}

</script>
{{-- --------------------------------------------------------------------- --}}


{{-- /////////////////////////////Search Role///////////////////////////////////// --}}
<script>
  $(document).on('keyup',function(e){
  e.preventDefault();
  let search_string=$('#search').val();

  $.ajax({
    url:"{{ route('search.role') }}",
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
