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





{{-- ///////////////////////////////to delete subsection ////////////////////////////// --}}

































{{-- ////////////////////////////////////////**add Subsection///////////////////////////////////--}}


<script>
  $(document).ready(function(){
    // console.log('Document is ready.');
    $(document).on("click", '.add_addon', function(e){
    e.preventDefault();

    let item_id =  $('#item_id').val();

   let addons =$('#addons').val();
   if (typeof addons === 'string') {
            addons = addons.split(',');
        }
   console.log(addons);

    $('.errMsgContainer').empty();
    // Clear previous error messages

    $.ajax({

      url: "{{ route('addons.store') }}",
      method: 'post',
      data:{
        "item_id":item_id,
        "addons":addons,
      } ,
      dataType: "json",
      headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },


      success: function(data) {
      console.log(data);
      $('.errMsgContainer').empty(); // Clear previous error messages
      $("#addAddonModal").modal("hide");
      $('#addAddonForm')[0].reset();
      $('#data-tableaddon2').load(location.href+' #data-tableaddon2');
      $('#successaddon1').show();
      /* hide success message after 4 seconds */
       setTimeout(function() {

        $('#successaddon1').hide();
       }, 2000); // 2000 milliseconds = 2 seconds

      $('.errMsgContainer').empty(); // Clear previous error messages
      },
      error: function(response) {
        console.log(response.responseJSON);
        $('.errMsgContainer').empty(); // Clear previous error messages
        errors = response.responseJSON.errors;
        $.each(errors, function(index, value){
          $('.errMsgContainer').append('<span class="text-danger">'+value+'</span><br />');
        });
      }
    });
  });
});

</script>



{{-- ////////////////////////////////////////**add subsection///////////////////////////////////--}}





{{-- //////////////////////////////DElete subsection////////////////////////////// --}}

<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.delete-addon', function (e) {
    e.preventDefault();
    var addon_id = $(this).data('id');
    var item_id = $(this).data('item');
    var url = "{{ route('addon.delete', ['addon' => ':addon', 'item' => ':item']) }}";
    url = url.replace(':addon', addon_id).replace(':item', item_id);
    console.log(item_id);
    if (confirm("Are you sure you want to delete this Addon?")) {
        $.ajax({
            url: url,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                addon: addon_id,
                item: item_id
            },
            success: function (data) {
              console.log(data);
                if (data.status == true) {
                    // subsection was deleted successfully
                    $('#data-tableaddon2').load(location.href + ' #data-tableaddon2');

                    $('#successaddon3').show();
                    /* hide success message after 4 seconds */
                    setTimeout(function () {
                        $('#successaddon3').hide();
                    }, 2000);
                } else if (data.status == 422) {
                    // subsection could not be deleted due to relationships
                    alert('You cannot delete this Addon as it is related to other tables.');
                } else if (data.status == 403) {
                    // subsection deletion forbidden due to relationships
                    alert('Deletion of this Addon is forbidden as it is related to other tables.');
                }
            },
            error: function (data) {
                console.log(data);
                if (data.status !== 500) {
                    alert('An error occurred while deleting the Addon.');
                }
            }
        });
    }
});


</script>

{{-- //////////////////////////////DElete subsection////////////////////////////// --}}
