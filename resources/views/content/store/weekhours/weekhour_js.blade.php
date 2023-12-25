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





{{-- ///////////////////////////////to update weekhour ////////////////////////////// --}}


<script>
  $(document).on("click", ".close-btn", function(e) {
    $('.errMsgContainer').empty(); // Clear error messages when form is closed
});



  $(document).on("click", '.update_weekhour_form', function() {
    /* To retrieve the data values from the form */
    let id = $(this).data('id');
    let to_time = $(this).data('to');
    let from_time = $(this).data('from');



    /** To set the values for each input **/
    $('#up_id').val(id);

      // Clear the values of the time inputs
    $('#uptotime').val('');
    $('#upfromtime').val('');

    $('#uptotime').val(to_time.split(' ')[1]);
    $('#upfromtime').val(from_time.split(' ')[1]);
    console.log($('#up_id').val(id));


});

$(document).on("click", ".update_weekhour", function(e) {
    e.preventDefault();
    let id = $('#up_id').val();
    let up_fromtimee = $('#upfromtime').val();
    let up_to_timme = $('#uptotime').val();


    console.log(id);
    console.log(up_fromtimee);
    console.log(up_to_timme);

    $('.errMsgContainer').empty(); // Clear previous error messages

    $.ajax({
        url: "{{ route('weekhours.update', ['weekhour' => ':id']) }}".replace(':id', id),
        method: "put",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: id,
            up_to_timme: up_to_timme,
            up_fromtimee: up_fromtimee,

        },
        dataType: "json",
        success: function(data) {
          $('.errMsgContainer').empty(); // Clear previous error messages

    if (data.status) {
      console.log(data);
        // Update successful
         $('#updateWeekhourModal').modal('hide');
         $('#data-week').load(location.href+' #data-week');
                $('#weekupdate').show();
                /* hide success message after 4 seconds */
                setTimeout(function() {
                    $('#weekupdate').hide();
                }, 2000); // 2000 milliseconds = 2 seconds
    } else {
                // Update failed
                console.error('Failed to update Weekhour');
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


































{{-- ////////////////////////////////////////**add Subsection///////////////////////////////////--}}


<script>
  $(document).ready(function(){
    // console.log('Document is ready.');
    $(document).on("click", '.add_weekhour', function(e){
    e.preventDefault();
    let store_id = $('#store_id').val();
    let day = $('#day').val();
    let fromTime=$('#fromtime').val();
    let toTime=$('#totime').val();
    // console.log(fromtime);
    // console.log(totime);
    // console.log(day);

    var formData = new FormData();

    formData.append('day', day);

    formData.append('fromTime', fromTime);
    formData.append('store_id', store_id);
    formData.append('toTime', toTime);

    $('.errMsgContainer').empty();
    // Clear previous error messages

    $.ajax({

      url: "{{ route('weekhours.store') }}",
      method: 'post',
      data: formData,
      dataType: "json",
      contentType: false,  // Set to false for FormData
      processData: false,  // Set to false for FormData
      headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },


      success: function(data) {

      $('.errMsgContainer').empty(); // Clear previous error messages
      $("#addweekhourModal").modal("hide");
      $('#addWeekhourForm')[0].reset();
      $('#data-week').load(location.href+' #data-week');
      $('#weekhoursu').show();
      /* hide success message after 4 seconds */
       setTimeout(function() {

        $('#weekhoursu').hide();
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

$(document).on('click', '.delete-weekhour', function (e) {
    e.preventDefault();
    var weekhour_id = $(this).data('id');
    console.log(weekhour_id);

    if (confirm("Are you sure you want to delete this Weekhour?")) {
        $.ajax({
            url: '{{ url("weekhours") }}/' + weekhour_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                weekhour: weekhour_id
            },
            success: function (data) {
              console.log(data);
                if (data.status == true) {
                    // subsection was deleted successfully
                    $('#data-week').load(location.href + ' #data-week');

                    $('#weekdelete').show();
                    /* hide success message after 4 seconds */
                    setTimeout(function () {
                        $('#weekdelete').hide();
                    }, 2000);
                } else if (data.status == 422) {
                    // subsection could not be deleted due to relationships
                    alert('You cannot delete this WeekHour as it is related to other tables.');
                } else if (data.status == 403) {
                    // subsection deletion forbidden due to relationships
                    alert('Deletion of this WeekHour is forbidden as it is related to other tables.');
                }
            },
            error: function (data) {
                console.log(data);
                if (data.status !== 500) {
                    alert('An error occurred while deleting the WeekHour.');
                }
            }
        });
    }
});


</script>

{{-- //////////////////////////////DElete subsection////////////////////////////// --}}
