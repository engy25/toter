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























{{-- /////////////////////////////Pagination OFFER///////////////////////////////////// --}}
<script>
  $(document).on('click', '.pagination a', function(e){

  e.preventDefault();
  let page = $(this).attr('href').split('page=')[1];
  offer(page);
});

function offer(page) {
    $.ajax({
      url: "/pagination/paginate-offers?page=" + page,
        type: 'get',
        success: function(data) {
            $('.table-responsive').html(data);
        }
    });
}

</script>
{{-- ////////////////////////////////////////////////////////////////// --}}


{{-- /////////////////////////////Search Offer///////////////////////////////////// --}}
 <script>
  $(document).on('keyup',function(e){
  e.preventDefault();
  let search_string=$('#search').val();
  // console.log(search_string);
  $.ajax({
    url:"{{ route('search.offer') }}",
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


{{-- ///////////////////////////// ///////////////////////////////////// --}}

{{-- Delete Offer --}}
<script>
  $(document).on('click', '.delete-offer', function (e) {
  $('.errMsgContainer').empty(); // Clear previous error messages
    e.preventDefault();

    e.stopPropagation();
    var offer_id = $(this).data('id');

    if (confirm("Are you sure you want to delete this Offer?")) {
        $.ajax({
            url: 'offers/' + offer_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                offer: offer_id
            },
            success: function (data) {
              ///
              if (data.status === true) {
                $('#data-table2').load(location.href + ' #data-table2');
                $('#success3').show();
                setTimeout(function () {
                  $('#success3').hide();
                }, 2000);
              } else if (data.status === false) {
                 // district could not be deleted due to relationships
                alert(data.msg);
              } else if (data.status === 403) {
                 // City deletion forbidden due to relationships
                alert(data.msg);

              }
            },
            error: function (data) {
              alert('Deletion of this Offer is forbidden as it is related to other tables.');
                console.log(data);
                if(data.status==false){
                  alert('Deletion of this Offer is forbidden as it is related to other tables.');
                }
                if (data.status !== 500) {
                    alert('An error occurred while deleting the Offer.');
                }
            }
        });
    }
});


</script>
{{-- ----------------------------------------------- --}}
