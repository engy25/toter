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
{{-- ///////////////////////////////to delete District ////////////////////////////// --}}









{{-- /** to fetch list of the data of countries and populate the dropdown in update */// --}}
<script>
  $(document).ready(function(){

    $.ajax({
  url: "{{ route('cities.display') }}",
  method: 'GET',
  dataType: "json",
  success: function (data) {
    // populate the dropdown with the received country data
    var options='<option value=""> Select City </option>';
    $.each(data, function (index, city) {
     var cityName = city.translations ? city.translations[0].name : city.name;

      options += '<option value="' + city.id + '">' + cityName+ '</option>';
    });
    $('#up_city_id').html(options);
  },
  error: function (response) {
    // Handle error if fetching countries fails
    console.error('Error fetching cities:', response);
  }
});


  });

</script>





{{-- /***update District*// --}}

<script>
  $(document).on("click", ".close-btn", function(e) {
    $('.errMsgContainer').empty(); // Clear error messages when form is closed
});


  $(document).on("click", '.update_district_form', function() {
    /* To retrieve the data values from the form */
    let id = $(this).data('id');
    let name_en = $(this).data('name_en');
    let name_ar = $(this).data('name_ar');

    let city_id =$(this).data('city_id');





    /** To set the values for each input **/
    $('#up_id').val(id);
    $('#up_name_en').val(name_en);
    $('#up_name_ar').val(name_ar);
    $('#up_city_id').val(city_id);

});

$(document).on("click", ".update_district", function(e) {
    e.preventDefault();
    let id = $('#up_id').val();
    let up_name_en = $('#up_name_en').val();
    let up_name_ar = $('#up_name_ar').val();
    let up_city_id = $('#up_city_id').val();
    console.log(id);
    console.log(up_name_en);
    console.log(up_name_ar);
    console.log(up_city_id);
    $('.errMsgContainer').empty(); // Clear previous error messages

    $.ajax({
        url: "{{ route('districts.update', ['district' => ':id']) }}".replace(':id', id),
        method: "put",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: id,
            up_name_en: up_name_en,
            up_name_ar: up_name_ar,
            up_city_id:up_city_id
        },
        dataType: "json",
        success: function(data) {
    console.log('AJAX request successful:', data);

    if (data.status) {
      console.log(data);
        // Update successful
         $('#updateDistrictModal').modal('hide');
         $('#data-table2').load(location.href+' #data-table2');
                $('#success2').show();
                /* hide success message after 4 seconds */
                setTimeout(function() {
                    $('#success2').hide();
                }, 2000); // 2000 milliseconds = 2 seconds
    } else {
                // Update failed
                console.error('Failed to update District');
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


{{-- ////////////////////////////////////////**add district///////////////////////////////////--}}
<script>
  $(document).ready(function(){
    $(document).on("click", '.add_district', function(e){
        e.preventDefault();
         let name_en = $('#name_en').val();
         let name_ar= $('#name_ar').val();
        let city_id=$('#city_id').val();


        $('.errMsgContainer').empty(); // Clear previous error messages

        $.ajax({
            url: "{{ route('districts.store') }}",
            method: 'post',
            data: {
                name_en: name_en,
                name_ar: name_ar,
                city_id:city_id
            },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              console.log(data);
              $('.errMsgContainer').empty(); // Clear previous error messages
              $("#addDistrictModal").modal("hide");
              $('#addDistrictForm')[0].reset();
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

{{-- ////////////////////////////////////////**add district///////////////////////////////////--}}





{{-- //////////////////////////////DElete City////////////////////////////// --}}

<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


// Use document or a container element that is always present on the page
$(document).on('click', '.delete-district', function (e) {
    e.preventDefault();
    e.stopPropagation(); 
    var district_id = $(this).data('id');

    if (confirm("Are you sure you want to delete this district?")) {
        $.ajax({
            url: 'districts/' + district_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                district: district_id
            },
            success: function (data) {
                if (data.status == true) {
                    // City was deleted successfully
                    $('#data-table2').load(location.href + ' #data-table2');

                    $('#success3').show();
                    /* hide success message after 4 seconds */
                    setTimeout(function () {
                        $('#success3').hide();
                    }, 2000);
                } else if (data.status == false) {
                    // City could not be deleted due to relationships
                    alert('You cannot delete this district as it is related to other tables.');
                } else if (data.status == 403) {
                    // City deletion forbidden due to relationships
                    alert('Deletion of this district is forbidden as it is related to other tables.');
                }
            },
            error: function (data) {
                console.log(data);
                if(data.status==false){
                  alert('Deletion of this district is forbidden as it is related to other tables.');
                }
                if (data.status !== 500) {
                    alert('An error occurred while deleting the district.');
                }
            }
        });
    }
});


</script>

{{-- //////////////////////////////DElete City////////////////////////////// --}}



{{-- /////////////////////////////Pagination City///////////////////////////////////// --}}
<script>
  $(document).on('click', '.pagination a', function(e){

  e.preventDefault();
  let page = $(this).attr('href').split('page=')[1];
  district(page);
});

function district(page) {
    $.ajax({
      url: "/pagination/paginate-district?page=" + page,
        type: 'get',
        success: function(data) {
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
    url:"{{ route('search.district') }}",
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


{{-- /////////////////////////////Search City///////////////////////////////////// --}}
