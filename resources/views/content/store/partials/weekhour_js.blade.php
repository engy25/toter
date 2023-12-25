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



{{-- /***update City*// --}}

<script>
  $(document).on("click", ".close-btn", function(e) {
    $('.errMsgContainer').empty(); // Clear error messages when form is closed
});


  $(document).on("click", '.update_weekhour_form', function() {
    /* To retrieve the data values from the form */
    // let id = $(this).data('id');
    // let name_en = $(this).data('name_en');
    // let name_ar = $(this).data('name_ar');

   // let country_id =$(this).data('country_id');



    /** To set the values for each input **/
    // $('#up_id').val(id);
    // $('#up_name_en').val(name_en);
    // $('#up_name_ar').val(name_ar);
    // $('#up_country_id').val(country_id);

});

$(document).on("click", ".update_weekhour_form", function(e) {
    e.preventDefault();
    let id = $('#up_id').val();
    let up_name_en = $('#up_name_en').val();
    let up_name_ar = $('#up_name_ar').val();
    let up_country_id = $('#up_country_id').val();
    $('.errMsgContainer').empty(); // Clear previous error messages

    $.ajax({
        url: "{{ route('weekhours.update', ['weekhour' => ':id']) }}".replace(':id', id),
        method: "put",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: id,
            up_name_en: up_name_en,
            up_name_ar: up_name_ar,
            up_country_id:up_country_id
        },
        dataType: "json",
        success: function(data) {
    console.log('AJAX request successful:', data);

    if (data.status) {
      console.log(data);
        // Update successful
         $('#updateModal').modal('hide');
         $('#data-table2').load(location.href+' #data-table2');
                $('#success2').show();
                /* hide success message after 4 seconds */
                setTimeout(function() {
                    $('#success2').hide();
                }, 2000); // 2000 milliseconds = 2 seconds
    } else {
                // Update failed
                console.error('Failed to update City');
            }
        },
        error: function(response) {

          $('.errMsgContainer').empty(); // Clear previous error messages
            errors = response.responseJSON.errors;
            $.each(errors, function(index, value) {
                $('.errMsgContainer').append('<span class="text-danger">' + value + '</span></br>');
            });
        }
    });
});
</script>
