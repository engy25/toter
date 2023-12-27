<!-- Include your other scripts and stylesheets -->

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr JS -->
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlRyjrVDFE3Ry_wivw70bqbH6VYccL9n0&callback=initMap" async
    defer></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        initialize();
    });

    function initialize() {
        const input = document.getElementById("address");
        const latitudeField = document.getElementById("address-latitude");
        const longitudeField = document.getElementById("address-longitude");
        console.log(latitudeField);
        console.log(longitudeField);

        const map = new google.maps.Map(document.getElementById('address-map'), {
            center: { lat: -33.8688, lng: 151.2195 },
            zoom: 13
        });

        const marker = new google.maps.Marker({
            map: map,
            position: { lat: -33.8688, lng: 151.2195 },
            draggable: true
        });

        const autocomplete = new google.maps.places.Autocomplete(input);

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            const place = autocomplete.getPlace();
            if (!place.geometry) {
                toastr.error("No details available for input: '" + place.name + "'");
                return;
            }

            map.setCenter(place.geometry.location);
            marker.setPosition(place.geometry.location);
            map.setZoom(17);

            // Update latitude and longitude fields
            latitudeField.value = place.geometry.location.lat();
            longitudeField.value = place.geometry.location.lng();
        });

        // Update marker position on drag
        google.maps.event.addListener(marker, 'dragend', function () {
            const position = marker.getPosition();
            latitudeField.value = position.lat();
            longitudeField.value = position.lng();
            console.log(latitudeField.value);
            console.log(longitudeField.value);
        });
    }
</script>

<style>
    /* Your custom styles for the location input field here */
    #address {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
    }

    #address-map-container {
        width: 100%;
        height: 400px;
    }
</style>


{{-- -------------------------------------------------------------------------------------------------------- --}}








<script>
  $(document).ready(function() {
    $('#city_id').change(function() {
      var cityId = $(this).val();

      // Make an AJAX request to fetch districts for the selected city
      $.ajax({
        url: '/cities/districts/' + cityId,
        type: 'GET',
        success: function (data) {
          // Populate the district dropdown with the received data
          var options = '<option value="">Select District</option>';

          $.each(data, function (index, district) {
            var districtName = district.translations.length > 0 ? district.translations[0].name : district.name;
            options += '<option value="' + district.id + '">' + districtName + '</option>';
          });
          $('#district_id').html(options);
        },
        error: function (response) {
          console.error('Error fetching districts:', response);
        }
      });
    });

    // // Function to fetch districts from the API using Fetch API
    // function fetchDistricts() {
    //   fetch('http://your-api-endpoint/cities/districts/18')
    //     .then(response => response.json())
    //     .then(data => {
    //       // Assign the fetched districts to the global variable
    //       apiDistricts = data;
    //     })
    //     .catch(error => {
    //       console.error('Error fetching districts:', error);
    //     });
    // }

    // // Call fetchDistricts to populate apiDistricts
    // fetchDistricts();
  });



</script>








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
      var countryName = country.translations ? country.translations[0].name : country.name;
      options += '<option value="' + country.id + '">' + countryName+ '</option>';
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
     var countryName = country.translations ? country.translations[0].name : country.name;

      options += '<option value="' + country.id + '">' + countryName+ '</option>';
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

    let country_id =$(this).data('country_id');



    /** To set the values for each input **/
    $('#up_id').val(id);
    $('#up_name_en').val(name_en);
    $('#up_name_ar').val(name_ar);
    $('#up_country_id').val(country_id);

});

$(document).on("click", ".update_city", function(e) {
    e.preventDefault();
    let id = $('#up_id').val();
    let up_name_en = $('#up_name_en').val();
    let up_name_ar = $('#up_name_ar').val();
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
        let country_id=$('#country_id').val();


        $('.errMsgContainer').empty(); // Clear previous error messages
        console.log(name_en);
        console.log(name_ar);
        console.log(country_id);
        $.ajax({
            url: "{{ route('cities.store') }}",
            method: 'post',
            data: {
                name_en: name_en,
                name_ar: name_ar,
                country_id:country_id
            },
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              console.log(data);
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

{{-- ////////////////////////////////////////**add city///////////////////////////////////--}}





{{-- //////////////////////////////DElete Store////////////////////////////// --}}

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
      url: "/pagination/paginate-store?page=" + page,
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
    url:"{{ route('search.store') }}",
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



{{-- /////////////////////////////Display subsections for the selected section///////////////////////////////////// --}}


<script>
  $(document).ready(function() {
      $('#section_id').change(function() {
          var sectionId = $(this).val();

          // Make an AJAX request to fetch subsections for the selected section
          $.ajax({
              url: '/getSubSections/' + sectionId,
              type: 'GET',
              success: function(data) {
                  // Populate the subsection dropdown with the received data
                  var options = '<option value="">Select Subsection</option>';

                  $.each(data, function(index, subSection) {
                      var subsectionName = subSection.translations ? subSection.translations[0].name : subSection.name;
                      options += '<option value="' + subSection.id + '">' + subsectionName + '</option>';
                  });
                  $('#sub_section_id').html(options);
              },
              error: function(response) {
                  console.error('Error fetching subsections:', response);
              }
          });
      });
  });
</script>

{{-- /////////////////////////////Display The subsections for the selected
section/////////////////////////////////////// --}}
