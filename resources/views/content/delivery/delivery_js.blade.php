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
  delivery(page);
});

function delivery(page) {
    $.ajax({
      url: "/pagination/paginate-delivery?page=" + page,
        type: 'get',
        success: function(data) {
            $('.table-responsive').html(data);
        }
    });
}

</script>
{{-- ////////////////////////////////////////////////////////////////// --}}


{{-- /////////////////////////////Search delivery///////////////////////////////////// --}}
<script>
  $(document).on('keyup',function(e){
  e.preventDefault();
  let search_string=$('#search').val();
  // console.log(search_string);
  $.ajax({
    url:"{{ route('search.delivery') }}",
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


{{-- /////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}


{{-- /** to fetch list of the data of days where not in sechedule of this delivery and populate the dropdown in update
*/// --}}
<script>
  $(document).ready(function(){

    $.ajax({
      url: "{{ route('getDaysNotInSchedule', ['deliveryId' => $delivery->id]) }}",
  method: 'GET',
  dataType: "json",
  success: function (data) {
    // populate the dropdown with the received country data
    var options='<option value=""> Select Day </option>';
    $.each(data, function (index, day) {
      var dayName = day.translations ? day.translations[0].name : day.name;
      options += '<option value="' + day.id + '">' + dayName+ '</option>';
    });
    $('#scheduleday').html(options);
  },
  error: function (response) {
    // Handle error if fetching countries fails
    console.error('Error fetching Days:', response);
  }
});


  });

</script>

{{-- -------------------------------------------------------------------------------- --}}



<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<script>
  // Initialize Select2
    $(document).ready(function() {
        $('#country').select2();
    });
</script>



{{-- Delete Weekhour Delivery --}}
<script>
  $(document).on('click', '.delete-weekhour', function (e) {
  $('.errMsgContainer').empty(); // Clear previous error messages
    e.preventDefault();

    e.stopPropagation();
    var weekhour_id = $(this).data('id');

    if (confirm("Are you sure you want to delete this Delivery Schedule?")) {
        $.ajax({
          url: '{{ url("deliveryschedules") }}/' + weekhour_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                deliveryschedule: weekhour_id
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
              alert('Deletion of this Delivery Schedule is forbidden as it is related to other tables.');
                console.log(data);

            }
        });
    }
});


</script>
{{-- ----------------------------------------------- --}}

{{-- Add Schedule Delivery --}}

<script>
  $(document).ready(function(){
    // console.log('Document is ready.');
    $(document).on("click", '.add_schedule', function(e){
    e.preventDefault();
    let delivery_id = $('#delivery_id').val();
    let day_id = $('#scheduleday').val();
    let fromTime=$('#fromtime').val();
    let toTime=$('#totime').val();


    var formData = new FormData();

    formData.append('day_id', day_id);

    formData.append('fromTime', fromTime);
    formData.append('delivery_id', delivery_id);
    formData.append('toTime', toTime);

    $('.errMsgContainer').empty();
    // Clear previous error messages

    $.ajax({

      url: "{{ route('deliveryschedules.store') }}",
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
      $("#addScheduleModal").modal("hide");
      $('#addScheduleForm')[0].reset();
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
          $('.errMsgContainer').append('<span class="text-danger">'+value+'</span><br />');
        });
      }
    });
  });
});

</script>

{{-- update delivery schedule --}}



{{-- ///////////////////////////////to update weekhour ////////////////////////////// --}}


<script>
  $(document).on("click", ".close-btn", function(e) {
    $('.errMsgContainer').empty(); // Clear error messages when form is closed
});



  $(document).on("click", '.update_schedule_form', function() {

    /* To retrieve the data values from the form */
    let id = $(this).data('id');
    let to_time = $(this).data('to_time');
    let from_time = $(this).data('from_time');

    // console.log(id);
    // console.log(to_time)
    // console.log(from_time)
    /** To set the values for each input **/

    $('#up_id').val(id);


    $('#uptotime').val(to_time);
    $('#upfromtime').val(from_time);

});

$(document).on("click", ".update_schedule", function(e) {
    e.preventDefault();
    let id = $('#up_id').val();
    let up_fromtimee = $('#upfromtime').val();
    let up_to_timme = $('#uptotime').val();
    console.log(155);

    console.log(id);
    console.log(up_fromtimee);
    console.log(up_to_timme);

    $('.errMsgContainer').empty(); // Clear previous error messages

    $.ajax({
        url: "{{ route('deliveryschedules.update', ['deliveryschedule' => ':id']) }}".replace(':id', id),
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
         $('#updateScheduleModal').modal('hide');
         $('#data-table2').load(location.href+' #data-table2');
                $('#successing2').show();
                /* hide success message after 4 seconds */
                setTimeout(function() {
                    $('#successing2').hide();
                }, 2000); // 2000 milliseconds = 2 seconds
    } else {
                // Update failed
                console.error('Failed to update Schedule');
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

{{-- -------------------------------------------------------------------------------------- --}}


{{-- Add Attendance Time --}}
<script>
  $(document).ready(function(){
    // console.log('Document is ready.');
    $(document).on("click", '.add_delivery_arrival', function(e){
    e.preventDefault();
    let delivery_id = $('#delivery_id').val();

    let fromTime=$('#fromTime').val();
    let toTime=$('#toTime').val();
    // console.log(delivery_id);
    // console.log(fromTime);
    // console.log(toTime);


    var formData = new FormData();

    formData.append('delivery_id', delivery_id);

    formData.append('fromTime', fromTime);
    formData.append('toTime', toTime);

    $('.errMsgContainer').empty();
    // Clear previous error messages

    $.ajax({

      url: "{{ route('arrivaltime.store') }}",
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
      $("#addDeliveryArrivalTimeModal").modal("hide");
      $('#add_delivery_arrival_time_form')[0].reset();
      $('#data-table5').load(location.href+' #data-table5');
      $('#success200').show();
      /* hide success message after 4 seconds */
       setTimeout(function() {

        $('#success200').hide();
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



{{-- -------------------------------------------------------------------------------------- --}}


{{-- Add Daily Caculation Time --}}
<script>
  $(document).ready(function(){
    // console.log('Document is ready.');
    $(document).on("click", '.add_daily_cal', function(e){
    e.preventDefault();
    let delivery_id = $('#delivery_id').val();

    let arrivalTimeId = $('#arrivalTimeId').val();



    let price=$('#price').val();

    console.log(delivery_id);
    console.log(arrivalTimeId);
    console.log(price);

    var formData = new FormData();

    formData.append('delivery_id', delivery_id);

    formData.append('price', price);
    formData.append('arrivalTimeId', arrivalTimeId);

    $('.errMsgContainer').empty();
    // Clear previous error messages

    $.ajax({

      url: "{{ route('dailyprice.delivery.store') }}",
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
        $("#dailyCalculationModal").modal("hide");
        $('#add_daily_cal_form')[0].reset();
        $('#data-table5').load(location.href + ' #data-table5', function () {
          $('#successPrice').show();

          setTimeout(function() { /* hide success message after 4 seconds */
            $('#successPrice').hide();
          }, 2000); // 2000 milliseconds = 2 seconds
        });
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


{{-- -------------------------------------------------------------------------------------- --}}


{{-- Add Incentives --}}
<script>
  $(document).ready(function(){
    // console.log('Document is ready.');
    $(document).on("click", '.add_incentive', function(e){
    e.preventDefault();
    let delivery_id = $('#delivery_id').val();
    let price=$('#price').val();

    console.log(delivery_id);
    console.log(price);

    var formData = new FormData();

    formData.append('delivery_id', delivery_id);

    formData.append('price', price);
   

    $('.errMsgContainer').empty();
    // Clear previous error messages

    $.ajax({

      url: "{{ route('dailyprice.delivery.store') }}",
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
        $("#dailyCalculationModal").modal("hide");
        $('#add_daily_cal_form')[0].reset();
        $('#data-table5').load(location.href + ' #data-table5', function () {
          $('#successPrice').show();

          setTimeout(function() { /* hide success message after 4 seconds */
            $('#successPrice').hide();
          }, 2000); // 2000 milliseconds = 2 seconds
        });
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
