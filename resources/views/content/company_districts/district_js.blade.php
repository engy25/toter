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



{{-- to fetch list of the districts depends on city --}}
<script>
  $(document).ready(function() {
  // Set an event listener for the change in the 'store_id' dropdown
  $('#city_id').change(function() {
    // Get the selected store_id
    const selectedCityId = $(this).val();

    // Make an AJAX request to fetch items based on the selected store_id
    $.ajax({
      url: "{{ url('city-district') }}/" + selectedCityId,
      method: 'GET',
      dataType: "json",
      success: function(data) {
        let options = '<option value=""> Select District </option>';
        $.each(data, function(index, district) {
          const districtName = district.translations ? district.translations[0].name : district.name;
          options += `<option value="${district.id}">${districtName}</option>`;
        });
        $('#from_id').html(options);
      },
      error: function(response) {
        console.error('Error fetching Districts:', response);
      }
    });
  });




});
</script>

{{-- ///////////////////////////////////////////////////////////// --}}







{{-- to fetch list of the districts depends on city --}}
<script>
  $(document).ready(function() {
  // Set an event listener for the change in the 'store_id' dropdown
  $('#to_city_id').change(function() {
    // Get the selected store_id
    const selectedToCityId = $(this).val();

    // Make an AJAX request to fetch items based on the selected store_id
    $.ajax({
      url: "{{ url('city-district') }}/" + selectedToCityId,
      method: 'GET',
      dataType: "json",
      success: function(data) {
        let options = '<option value=""> Select District </option>';
        $.each(data, function(index, district) {
          const districtName = district.translations ? district.translations[0].name : district.name;
          options += `<option value="${district.id}">${districtName}</option>`;
        });
        $('#to_id').html(options);
      },
      error: function(response) {
      }
    });
  });




});
</script>
  {{-- ///////////////////////////////////////////////////////////// --}}











{{-- /***update District*// --}}

 <script>
  $(document).on("click", ".close-btn", function(e) {
    $('.errMsgContainer').empty(); // Clear error messages when form is closed
});


  $(document).on("click", '.update_district_form', function() {
    /* To retrieve the data values from the form */
    let id = $(this).data('id');
    let delivery_charge = $(this).data('delivery_charge');



    /** To set the values for each input **/
    $('#up_id').val(id);
    $('#updelivery_charge').val(delivery_charge);


});

$(document).on("click", ".update_company_district", function(e) {
    e.preventDefault();
    let id = $('#up_id').val();
    let updelivery_charge = $('#updelivery_charge').val();

    console.log(id);
    console.log(updelivery_charge);

    $('.errMsgContainer').empty(); // Clear previous error messages

    $.ajax({
        url: "{{ route('companydistricts.update', ['companydistrict' => ':id']) }}".replace(':id', id),
        method: "put",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: id,
            updelivery_charge: updelivery_charge,

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
                console.error('Failed to update Company District');
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
    $(document).on("click", '.add_districtCompany', function(e){
        e.preventDefault();

         let from_id=$('#from_id').val();
         let to_id=$('#to_id').val();
         let delivery_charge=$('#delivery_charge').val();
        //  console.log(from);
        // console.log(to);

        $('.errMsgContainer').empty(); // Clear previous error messages

        $.ajax({
            url: "{{ route('companydistricts.store') }}",
            method: 'post',
            data: {

              from_id: from_id,
              to_id: to_id,
              delivery_charge:delivery_charge

            },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              console.log(data);
              $('.errMsgContainer').empty(); // Clear previous error messages
              $("#addDistrictCompanyModal").modal("hide");
              $('#addDistrictCompanyForm')[0].reset();
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





{{-- //////////////////////////////Delete Company District////////////////////////////// --}}

<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.delete-district', function (e) {
    e.preventDefault();
    var district_id = $(this).data('id');


    if (confirm("Are you sure you want to delete this Company district?")) {
        $.ajax({
            url: '{{ url("companydistricts") }}/' + district_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                companydistricts: district_id
            },
            success: function (data) {
              console.log(data);
                if (data.status == true) {
                    // subsection was deleted successfully
                    $('#data-table2').load(location.href + ' #data-table2');

                    $('#success3').show();
                    /* hide success message after 4 seconds */
                    setTimeout(function () {
                        $('#success3').hide();
                    }, 2000);
                } else if (data.status == 422) {
                    // subsection could not be deleted due to relationships
                    alert('You cannot delete this Company District as it is related to other tables.');
                } else if (data.status == 403) {
                    // subsection deletion forbidden due to relationships
                    alert('Deletion of this  Company District is forbidden as it is related to other tables.');
                }
            },
            error: function (data) {
                console.log(data);
                if (data.status !== 500) {
                    alert('You cannot delete this Company District as it is used.');
                }
            }
        });
    }
});


</script>

{{-- //////////////////////////////////////////////////////////////////////////////// --}}



{{-- /////////////////////////////Pagination City///////////////////////////////////// --}}
<script>
  $(document).on('click', '.pagination a', function(e){

  e.preventDefault();
  let page = $(this).attr('href').split('page=')[1];
  companydisctrict(page);
});

function companydisctrict(page) {
    $.ajax({
      url: "/pagination/paginate-companydisctrict?page=" + page,
        type: 'get',
        success: function(data) {
          console.log(5);
            $('.table-responsive').html(data);
        },
        error: function(response) {
          // console.log(response.error);

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
    url:"{{ route('search.companydisctrict') }}",
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
