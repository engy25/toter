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






{{-- /** to fetch list of the data of countries and populate the dropdown*/// --}}
<script>
  $(document).ready(function(){

    $.ajax({
  url: "{{ route('countries.display') }}",
  method: 'GET',
  dataType: "json",
  success: function (data) {
    // populate the dropdown with the received country data
    var options='<option value=""> Select Country </option>';
    $.each(data, function (index, country) {
      options += '<option value="' + country.id + '">' + country.name + '</option>';
    });
    $('#country_id').html(options);
  },
  error: function (response) {
    // Handle error if fetching countries fails
    console.error('Error fetching countries:', response);
  }
});


  });

</script>








{{-- /** to fetch list of the data of countries and populate the dropdown in update */// --}}
<script>
  $(document).ready(function(){

    $.ajax({
  url: "{{ route('countries.display') }}",
  method: 'GET',
  dataType: "json",
  success: function (data) {
    // populate the dropdown with the received country data
    var options='<option value=""> Select Country </option>';
    $.each(data, function (index, country) {
      options += '<option value="' + country.id + '">' + country.name + '</option>';
    });
    $('#up_country_id').html(options);
  },
  error: function (response) {
    // Handle error if fetching countries fails
    console.error('Error fetching countries:', response);
  }
});


  });

</script>





{{-- /***update City*// --}}

<script>
  $(document).on("click", ".close-btn", function(e) {
    $('.errMsgContainer').empty(); // Clear error messages when form is closed
});


  $(document).on("click", '.update_city_form', function() {
    /* To retrieve the data values from the form */
    let id = $(this).data('id');
    let name_en = $(this).data('name_en');
    let name_ar = $(this).data('name_ar');
    let district_en = $(this).data('district_en');
    let district_ar = $(this).data('district_ar');
    let population = $(this).data('population');
    let countrycode = $(this).data('countrycode');
    let country_id =$(this).data('country_id');


    /** To set the values for each input **/
    $('#up_id').val(id);
    $('#up_name_en').val(name_en);
    $('#up_name_ar').val(name_ar);
    $('#up_district_en').val(district_en);
    $('#up_district_ar').val(district_ar);
    $('#up_population').val(population);
    $('#up_CountryCode').val(countrycode);
    $('#up_country_id').val(country_id);
});

$(document).on("click", ".update_city", function(e) {
    e.preventDefault();
    let id = $('#up_id').val();
    let up_name_en = $('#up_name_en').val();
    let up_name_ar = $('#up_name_ar').val();
    let up_district_ar = $('#up_district_ar').val();
    let up_district_en = $('#up_district_en').val();
    let up_CountryCode = $('#up_CountryCode').val();
    let up_population = $('#up_population').val();
    let up_country_id = $('#up_country_id').val();
    $('.errMsgContainer').empty(); // Clear previous error messages

    $.ajax({
        url: "{{ route('cities.update', ['city' => ':id']) }}".replace(':id', id),
        method: "put",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: id,
            up_name_en: up_name_en,
            up_name_ar: up_name_ar,
            up_district_en: up_district_en,
            up_district_ar: up_district_ar,
            up_CountryCode: up_CountryCode,
            up_population: up_population,
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


{{-- ////////////////////////////////////////**add city///////////////////////////////////--}}
<script>
  $(document).ready(function(){
    $(document).on("click", '.add_city', function(e){
        e.preventDefault();
        let name_en = $('#name_en').val();
        let name_ar= $('#name_ar').val();
        let population= $('#population').val();
        let CountryCode = $('#CountryCode').val();
        let district_en= $('#district_en').val();
        let district_ar= $('#district_ar').val();
        let country_id=$('#country_id').val();

        $('.errMsgContainer').empty(); // Clear previous error messages

        $.ajax({
            url: "{{ route('cities.store') }}",
            method: 'post',
            data: {
                name_en: name_en,
                name_ar: name_ar,
                district_en: district_en,
                district_ar: district_ar,
                CountryCode: CountryCode,
                population: population,
                country_id:country_id
            },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              $('.errMsgContainer').empty(); // Clear previous error messages
              $("#addModal").modal("hide");
              $('#addCityForm')[0].reset();
              $('#data-table2').load(location.href+' #data-table2');
              $('#success1').show();
                /* hide success message after 4 seconds */
                setTimeout(function() {
                    $('#success1').hide();
                }, 2000); // 2000 milliseconds = 2 seconds
              $('.errMsgContainer').empty(); // Clear previous error messages

            },
            error: function(response) {

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

{{-- ////////////////////////////////////////**add city///////////////////////////////////--}}





{{-- //////////////////////////////DElete City////////////////////////////// --}}

<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.delete-city').on('click', function(e) {
    e.preventDefault();
    var city_id = $(this).data('id');

    if (confirm("Are you sure you want to delete this city?")) {
        $.ajax({
            url: 'cities/' + city_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                city: city_id
            },
            success: function(data) {
                if (data.status == true) {
                    // City was deleted successfully
                    $('#data-table2').load(location.href + ' #data-table2');
                    $('#success3').show();
                    /* hide success message after 4 seconds */
                    setTimeout(function() {
                        $('#success3').hide();
                    }, 2000);
                } else if (data.status == 422) {
                    // City could not be deleted due to relationships
                    alert('You cannot delete this city as it is related to other tables.');
                } else if (data.status == 403) {
                    // City deletion forbidden due to relationships
                    alert('Deletion of this city is forbidden as it is related to other tables.');
                }
            },
            error: function(data) {
                console.log(data);
                if (data.status !== 500) {
                    alert('An error occurred while deleting the city.');
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
  city(page);
});

function city(page) {
    $.ajax({
      url: "/pagination/paginate-city?page=" + page,
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
    url:"{{ route('search.city') }}",
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
