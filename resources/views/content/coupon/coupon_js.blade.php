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


{{-- show the coupon --}}

<script>
  $(document).ready(function() {
    $('.show-coupon').on('click', function(e) {
      e.preventDefault();

      var id = $(this).data('id');

      // Toggle the correct modal using Bootstrap's modal method
      $('#showCouponModal').modal('show');
    });
  });
</script>


{{-- /** to fetch list of the data of stores and populate the dropdown*/// --}}
<script>
  $(document).ready(function(){

    $.ajax({
  url: "{{ route('stores.display') }}",
  method: 'GET',
  dataType: "json",
  success: function (data) {
    // populate the dropdown with the received country data
    var options='<option value=""> Select Store </option>';
    $.each(data, function (index, store) {
      var storeName = store.translations ? store.translations[0].name : store.name;
      options += '<option value="' + store.id + '">' + storeName+ '</option>';
    });
    $('#store_id').html(options);
  },
  error: function (response) {
    // Handle error if fetching countries fails
    console.error('Error fetching Stores:', response);
  }
});


  });

</script>





{{-- /** to fetch list of the data of stores and populate the dropdown in update */// --}}
<script>
  $(document).ready(function(){

    $.ajax({
  url: "{{ route('stores.display') }}",
  method: 'GET',
  dataType: "json",
  success: function (data) {

    // populate the dropdown with the received store data
    var options='<option value=""> Select Store </option>';
    $.each(data, function (index, store) {
     var storeName = store.translations ? store.translations[0].name : store.name;

      options += '<option value="' + store.id + '">' + storeName+ '</option>';
    });
    $('#up_store_id').html(options);
  },
  error: function (response) {

    // Handle error if fetching countries fails
    console.error('Error fetching Store:', response);
  }
});


  });

</script>





{{-- /***update Coupon*// --}}

<script>
  $(document).on("click", ".close-btn", function(e) {
    $('.errMsgContainer').empty(); // Clear error messages when form is closed
});


  $(document).on("click", '.update_coupon_form', function() {
    /* To retrieve the data values from the form */
    let id = $(this).data('id');
    let code = $(this).data('code');
    let is_active = $(this).data('is_active');
    let isChecked = is_active === 1;
    let discount_percentage = $(this).data('discount_percentage');
    let max_user_used_code = $(this).data('max_user_used_code');
    let expire_date = $(this).data('expire_date');
    let store_id =$(this).data('store_id');



    /** To set the values for each input **/
    $('#up_id').val(id);
    $('#up_code').val(code);
    $('#up_store_id').val(store_id);
    $('#upexpire_date').val(expire_date);
    $('#is_active').prop('checked', isChecked);

    $('#updiscount_percentage').val(discount_percentage);
    $('#upmax_user_used_code').val(max_user_used_code);



});
$(document).on("click", ".update_coupon", function (e) {
    e.preventDefault();
    let id = $('#up_id').val();
    let up_code = $('#up_code').val();
    let up_store_id = $('#up_store_id').val();
    let upexpire_date = $('#upexpire_date').val();
    let is_active = $('#is_active').prop('checked') ? 1 : 0;
    let updiscount_percentage = $('#updiscount_percentage').val();
    let upmax_user_used_code = $('#upmax_user_used_code').val();

    $('.errMsgContainer').empty(); // Clear previous error messages

    $.ajax({
        url: `{{ route('coupons.update', ['coupon' => ':id']) }}`.replace(':id', id),
        method: "put",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            up_code: up_code,
            up_store_id: up_store_id,
            upexpire_date: upexpire_date,
            is_active: is_active,
            updiscount_percentage: updiscount_percentage,
            upmax_user_used_code: upmax_user_used_code
        },
        dataType: "json",
        success: function (data) {
            console.log('AJAX request successful:', data);

            if (data.status) {
                console.log(data);
                // Update successful
                $('#updateCouponModal').modal('hide');
                $('#data-table2').load(location.href + ' #data-table2');
                $('#success2').show();
                /* hide success message after 4 seconds */
                setTimeout(function () {
                    $('#success2').hide();
                }, 2000); // 2000 milliseconds = 2 seconds
            } else {
                // Update failed
                console.error('Failed to update Coupon');
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
              $('#updateCouponModal').modal('hide');
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


{{-- *-------------------------------------------------------* --}}

{{-- ////////////////////////////////////////**add coupon///////////////////////////////////--}}
<script>
  $(document).ready(function(){
    $(document).on("click", '.add_coupon', function(e){
        e.preventDefault();
         let code = $('#code').val();
         let discount_percentage= $('#discount_percentage').val();
         let expire_date=$('#expire_date').val();
         let max_user_used_code=$('#max_user_used_code').val();

         let store_id=$('#store_id').val();

        $('.errMsgContainer').empty(); // Clear previous error messages
        console.log(discount_percentage);
        console.log(code);
        console.log(max_user_used_code);

        console.log(store_id);
        $.ajax({
            url: "{{ route('coupons.store') }}",
            method: 'post',
            data: {
                code: code,
                expire_date: expire_date,
                max_user_used_code:max_user_used_code,

                store_id: store_id,
                discount_percentage:discount_percentage
            },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              console.log(data);
              $('.errMsgContainer').empty(); // Clear previous error messages
              $("#addCouponModal").modal("hide");
              $('#addCouponForm')[0].reset();
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

{{----------------------------------------------------------------}}





{{-- //////////////////////////////Delete Coupon////////////////////////////// --}}

<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Use document or a container element that is always present on the page
$(document).on('click', '.delete-coupon', function (e) {
    e.preventDefault();
    var coupon_id = $(this).data('id');

    if (confirm("Are you sure you want to delete this Coupon?")) {
        $.ajax({
            url: 'coupons/' + coupon_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                coupon: coupon_id
            },
            success: function (data) {
                if (data.status == true) {
                    // coupon was deleted successfully
                    $('#data-table2').load(location.href + ' #data-table2');

                    $('#success3').show();
                    /* hide success message after 4 seconds */
                    setTimeout(function () {
                        $('#success3').hide();
                    }, 2000);
                } else if (data.status == 422) {
                    // coupon could not be deleted due to relationships
                    alert('You cannot delete this coupon as it is related to other tables.');
                } else if (data.status == 403) {
                    // coupon deletion forbidden due to relationships
                    alert('Deletion of this coupon is forbidden as it is related to other tables.');
                }
            },
            error: function (data) {
                console.log(data);

                    alert('This Coupon Is Used You Canoot Delete It, You Can Make It Not Active From Edit Button ');

            }
        });
    }
});


</script>
{{-- --------------------------------------------------------------------- --}}


{{-- /////////////////////////////Pagination Coupon///////////////////////////////////// --}}
<script>
  $(document).on('click', '.pagination a', function(e){


  e.preventDefault();
  let page = $(this).attr('href').split('page=')[1];
  coupon(page);
});

function coupon(page) {
    $.ajax({
      url: "/pagination/paginate-coupon?page=" + page,
        type: 'get',
        success: function(data) {
          console.log(data)
            $('.table-responsive').html(data);
        }
    });
}

</script>
{{-- /////////////////////////////Pagination City///////////////////////////////////// --}}


{{-- /////////////////////////////Search City///////////////////////////////////// --}}
<script>
  $(document).on('keyup',function(e){
  e.preventDefault();
  let search_string=$('#search').val();
  // console.log(search_string);
  $.ajax({
    url:"{{ route('search.coupon') }}",
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


{{-- ///////////////////////////////////////////////////////////////// --}}


