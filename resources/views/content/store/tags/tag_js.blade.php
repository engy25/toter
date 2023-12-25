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




























{{-- /***update Tag*// --}}



<script>
  $(document).on("click", ".close-btn", function(e) {
    $('.errMsgContainer').empty(); // Clear error messages when form is closed
});



  $(document).on("click", '.update_tag_form', function() {
    /* To retrieve the data values from the form */
    let id = $(this).data('id');
    let name_en = $(this).data('name_en');
    let name_ar = $(this).data('name_ar');
    let description_en = $(this).data('description_en');
    let description_ar = $(this).data('description_ar');




    /** To set the values for each input **/
    $('#up_id').val(id);
    $('#up_names_en').val(name_en);
    $('#up_names_ar').val(name_ar);
    $('#up_descriptions_en').val(description_en);
    $('#up_descriptions_ar').val(description_ar);


});

$(document).on("click", ".update_tag", function(e) {
    e.preventDefault();
    let id = $('#up_id').val();
    let up_name_en = $('#up_names_en').val();
    let up_name_ar = $('#up_names_ar').val();
    let up_description_en = $('#up_descriptions_en').val();
    let up_description_ar = $('#up_descriptions_ar').val();

    // console.log(id);
    // console.log(up_name_en);
    // console.log(up_name_ar);
    // console.log(up_description_en);
    // console.log(up_description_ar);

    $('.errMsgContainer').empty(); // Clear previous error messages

    $.ajax({
        url: "{{ route('tags.update', ['tag' => ':id']) }}".replace(':id', id),
        method: "put",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: id,
            up_name_en: up_name_en,
            up_name_ar: up_name_ar,
            up_description_en: up_description_en,
            up_description_ar: up_description_ar
        },
        dataType: "json",
        success: function(data) {
    console.log('AJAX request successful:', data);

    if (data.status) {
      console.log(data);
        // Update successful
         $('#updateTagModal').modal('hide');
         $('#data-tabletag').load(location.href+' #data-tabletag');
                $('#tagupdate').show();
                /* hide success message after 4 seconds */
                setTimeout(function() {
                    $('#tagupdate').hide();
                }, 2000); // 2000 milliseconds = 2 seconds
    } else {
                // Update failed
                console.error('Failed to update Tag');
            }
        },
        error: function(response) {
          console.log(response.responseJSON);

          $('.errMsgContainer').empty(); // Clear previous error messages
            errors = response.responseJSON.errors;
            $.each(errors, function(index, value) {
                $('.errMsgContainer').append('<span class="text-danger">' + value + '</span></br>');
            });
        }
    });
});
</script>













{{-- //////////////////////////////DElete subsection////////////////////////////// --}}

<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.delete-tag', function (e) {
    e.preventDefault();
    var tag_id = $(this).data('id');

    if (confirm("Are you sure you want to delete this Tag?")) {
        $.ajax({
            url: '{{ url("tags") }}/' + tag_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                 tag: tag_id
            },
            success: function (data) {
              console.log(data);
                if (data.status == true) {
                    // subsection was deleted successfully
                    $('#data-tabletag').load(location.href + ' #data-tabletag');

                    $('#tagdelete').show();
                    /* hide success message after 4 seconds */
                    setTimeout(function () {
                        $('#tagdelete').hide();
                    }, 2000);
                } else if (data.status == 422) {
                    // subsection could not be deleted due to relationships
                    alert('You cannot delete this Tag as it is related to other tables.');
                } else if (data.status == 403) {
                    // subsection deletion forbidden due to relationships
                    alert('Deletion of this Tag is forbidden as it is related to other tables.');
                }
            },
            error: function (data) {
                console.log(data);
                if (data.status !== 500) {
                    alert('An error occurred while deleting the Tag.');
                }
            }
        });
    }
});


</script>

{{-- //////////////////////////////DElete subsection////////////////////////////// --}}



{{-- ////////////////////////////////////////**add Subsection///////////////////////////////////--}}


<script>
  $(document).ready(function(){
    // console.log('Document is ready.');
    $(document).on("click", '.add_tag', function(e){
    e.preventDefault();
    let store_id = $('#store_id').val();
    let name_en = $('#thename_en').val();
    let name_ar = $('#thename_ar').val();
    let description_en = $('#description_en').val();
    let description_ar = $('#description_ar').val();

    let image = $('#images')[0].files[0];
    var formData = new FormData();

    formData.append('name_en', name_en);
    formData.append('name_ar', name_ar);
    formData.append('description_en', description_en);
    formData.append('store_id', store_id);
    formData.append('description_ar', description_ar);

    $('.errMsgContainer').empty();
    // Clear previous error messages

    $.ajax({

      url: "{{ route('tags.store') }}",
      method: 'post',
      data: formData,
      dataType: "json",
      contentType: false,  // Set to false for FormData
      processData: false,  // Set to false for FormData
      headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },


      success: function(data) {
      console.log(data);
      $('.errMsgContainer').empty(); // Clear previous error messages
      $("#addTagModal").modal("hide");
      $('#addTagForm')[0].reset();
      $('#data-tabletag').load(location.href+' #data-tabletag');
      $('#tagstore').show();
      /* hide success message after 4 seconds */
       setTimeout(function() {

        $('#tagstore').hide();
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
