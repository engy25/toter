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
{{-- ///////////////////////////////to delete country ////////////////////////////// --}}

<style>
  label.required:after {
    content: " *";
    color: red;
  }
</style>





{{-- /** to fetch list of the data of Currencies and populate the dropdown*/// --}}
<script>
  $(document).ready(function(){

    $.ajax({
  url: "{{ route('currencies.display') }}",
  method: 'GET',
  dataType: "json",
  success: function (data) {
    // populate the dropdown with the received country data
    var options='<option value=""> Select Currency </option>';
    $.each(data, function (index, currency) {
      options += '<option value="' + currency.id + '">' + currency.name + '</option>';
    });
    $('#currency_id').html(options);
  },
  error: function (response) {
    // Handle error if fetching countries fails
    console.error('Error fetching currencies:', response);
  }
});


  });

</script>





{{-- /***update City*// --}}

<script>
  $(document).on("click", ".close-btn", function(e) {
    $('.errMsgContainer').empty(); // Clear error messages when form is closed
});


$(document).on("click", '.update_country_form', function() {
    /* To retrieve the data values from the form */
    let id = $(this).data('id');
    let name_en = $(this).data('name_en');
    let name_ar = $(this).data('name_ar');
    let district_en = $(this).data('district_en');
    let district_ar = $(this).data('district_ar');
    let population = $(this).data('population');
    let countrycode = $(this).data('countrycode');

    /** To set the values for each input **/
    $('#up_id').val(id);
    $('#up_name_en').val(name_en);
    $('#up_name_ar').val(name_ar);
    $('#up_district_en').val(district_en);
    $('#up_district_ar').val(district_ar);
    $('#up_population').val(population);
    $('#up_code').val(countrycode); // Assuming 'countrycode' corresponds to 'code' field
    $('#up_continent').val($(this).data('continent')); // Assuming 'continent' corresponds to 'continent' field
    // Set other input fields as needed
});

$(document).on("click", ".update_country", function(e) {
    e.preventDefault();
    let id = $('#up_id').val();
    let up_name_en = $('#up_name_en').val();
    let up_name_ar = $('#up_name_ar').val();
    let up_district_ar = $('#up_district_ar').val();
    let up_district_en = $('#up_district_en').val();
    let up_code = $('#up_code').val(); // Assuming 'code' corresponds to 'countrycode' field
    let up_continent = $('#up_continent').val(); // Assuming 'continent' corresponds to 'continent' field
    let up_population = $('#up_population').val();

    $('.errMsgContainer').empty(); // Clear previous error messages

    $.ajax({
        url: "{{ route('countries.update', ['country' => ':id']) }}".replace(':id', id),
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
            up_code: up_code, // Assuming 'code' corresponds to 'countrycode' field
            up_continent: up_continent, // Assuming 'continent' corresponds to 'continent' field
            up_population: up_population
            // Add other fields as needed
        },
        dataType: "json",
        success: function(data) {
            console.log('AJAX request successful:', data);

            if (data.status) {
                console.log(data);
                // Update successful
                $('#updateModal').modal('hide');
                $('#data-table2').load(location.href + ' #data-table2');
                $('#success2').show();
                /* hide success message after 4 seconds */
                setTimeout(function() {
                    $('#success2').hide();
                }, 2000); // 2000 milliseconds = 2 seconds
            } else {
                // Update failed
                console.error('Failed to update Country');
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


{{-- ////////////////////////////////////////**add country///////////////////////////////////--}}
<script>
  $(document).ready(function(){
    $(document).on("click", '.add_country', function(e){
        e.preventDefault();
        let name_en = $('#name_en').val();
        let name_ar= $('#name_ar').val();
        let population= $('#population').val();
        let code = $('#code').val();
        let code2 = $('#code2').val();
        let region_en= $('#region_en').val();
        let region_ar= $('#region_ar').val();
        let localName_en= $('#localName_en').val();
        let localName_ar= $('#localName_ar').val();
        let HeadOfState= $('#HeadOfState').val();
        let capital= $('#capital').val();
        let governmentForm_en= $('#governmentForm_en').val();
        let governmentForm_ar= $('#governmentForm_ar').val();
        let IndepYear= $('#IndepYear').val();
        let surfaceArea= $('#surfaceArea').val();
        let lifeExpectancy= $('#lifeExpectancy').val();
        let GNP= $('#GNP').val();
        let GNPOld= $('#GNPOld').val();
        let continent= $('#continent').val();
        let currency_id=$('#currency_id').val();

// // Concatenate values into a string
// let allValues = `Name (English): ${name_en}
// Name (Arabic): ${name_ar}
// Population: ${population}
// Code: ${code}
// Code2: ${code2}
// Region (English): ${region_en}
// Region (Arabic): ${region_ar}
// Local Name (English): ${localName_en}
// Local Name (Arabic): ${localName_ar}
// Head of State: ${HeadOfState}
// Capital: ${capital}
// Government Form (English): ${governmentForm_en}
// Government Form (Arabic): ${governmentForm_ar}
// Independence Year: ${IndepYear}
// Surface Area: ${surfaceArea}
// Life Expectancy: ${lifeExpectancy}
// GNP: ${GNP}
// GNP Old: ${GNPOld}
// Continent: ${continent}
// Currency ID: ${currency_id}`;

// // Print the concatenated string
// console.log(allValues);




        $('.errMsgContainer').empty(); // Clear previous error messages

        $.ajax({
            url: "{{ route('countries.store') }}",
            method: 'post',
            data: {
                name_en: name_en,
                name_ar: name_ar,
                population: population,
                code: code,
                code2: code2,
                region_en: region_en,
                region_ar:region_ar,
                localName_en: localName_en,
                localName_ar: localName_ar,
                HeadOfState: HeadOfState,
                capital: capital,
                governmentForm_en: governmentForm_en,
                governmentForm_ar:governmentForm_ar,
                IndepYear: IndepYear,
                surfaceArea: surfaceArea,
                lifeExpectancy: lifeExpectancy,
                GNP:GNP,
                GNPOld: GNPOld,
                continent: continent,
                currency_id: currency_id,
            },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              console.log(data);
              $('.errMsgContainer').empty(); // Clear previous error messages
              $("#addModal").modal("hide");
              $('#addCountryForm')[0].reset();
              $('#data-table2').load(location.href+' #data-table2');
              $('#success1').show();
                /* hide success message after 4 seconds */
                setTimeout(function() {
                    $('#success1').hide();
                }, 2000); // 2000 milliseconds = 2 seconds
              $('.errMsgContainer').empty(); // Clear previous error messages

            },
            error: function(response) {
              console.log(response);

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

{{-- ////////////////////////////////////////**add country///////////////////////////////////--}}





{{-- //////////////////////////////DElete country////////////////////////////// --}}

<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
<script>
$('.delete-country').on('click', function(e) {
    e.preventDefault();
    var country_id = $(this).data('id');

    if (confirm("Are you sure you want to delete this country?")) {
        $.ajax({
            url: 'countries/' + country_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                country: country_id
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
                    alert('You cannot delete this country as it is related to other tables.');
                } else if (data.status == 403) {
                    // City deletion forbidden due to relationships
                    alert('Deletion of this country is forbidden as it is related to other tables.');
                }
            },
            error: function(data) {
                console.log(data);
                if (data.status !== 500) {
                    alert('An error occurred while deleting the country.');
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
  country(page);
});

function country(page) {
    $.ajax({
      url: "/pagination/paginate-country?page=" + page,
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
    url:"{{ route('search.country') }}",
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
