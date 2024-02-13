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









{{-- /////////////////////////////Pagination Delivery///////////////////////////////////// --}}
<script>
  $(document).on('click', '.pagination a', function(e){

  e.preventDefault();
  let page = $(this).attr('href').split('page=')[1];
  user(page);

});

function user(page) {
    $.ajax({
      url: "/pagination/paginate-restaurantuser/"  + "?page=" + page, // Updated URL
        type: 'get',
        success: function(data) {
            $('.table-responsive').html(data);
        },

    });
}

</script>
{{-- ////////////////////////////////////////////////////////////////// --}}


{{-- /////////////////////////////Search User///////////////////////////////////// --}}
<script>
  $(document).on('keyup',function(e){
  e.preventDefault();
  let search_string=$('#search').val();
  // console.log(search_string);
  $.ajax({
    url:"{{ route('search.restaurantuser') }}",
    method:'GET',
    data:{
      search_string:search_string
    },
    success:function(data){
      console.log(data);

      $('.table-responsive').html(data);
    },
    error:function(response){
      console.log(response);
    }

  });



})

</script>



{{-- /////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}

{{-- Delete User That Belongs to  Restaurant Dashboard--}}

<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.delete-user', function (e) {
    e.preventDefault();
    var user_id = $(this).data('id');

    if (confirm("Are you sure you want to delete this User?")) {
        $.ajax({
            url: '{{ url("restaurantusers") }}/' + user_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                restaurantuser: user_id
            },
            success: function (data) {
              console.log(data);
                if (data.status == true) {
                    // subsection was deleted successfully
                    $('#data-table2').load(location.href + ' #data-table2');

                    $('#success1').show();
                    /* hide success message after 4 seconds */
                    setTimeout(function () {
                        $('#success1').hide();
                    }, 2000);
                } else if (data.status == 422) {
                    // subsection could not be deleted due to relationships
                    alert('You cannot delete this User as it is related to other tables.');
                } else if (data.status == 403) {
                    // subsection deletion forbidden due to relationships
                    alert('Deletion of this User is forbidden as it is related to other tables.');
                }
            },
            error: function (data) {
                console.log(data);
                if (data.status !== 500) {
                    alert('An error occurred while deleting the User.');
                }
            }
        });
    }
});


</script>

{{-- //////////////////////////////DElete subsection////////////////////////////// --}}
