<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>

{{-- <script>
  $(document).ready(function(){
    $(document).on("click", '.add_product', function(e){
        e.preventDefault();
        let name = $('#name').val();
        let details = $('#details').val();

        let price = $('#price').val();
        $.ajax({
            url: "{{ route('admin.products.store') }}",
            method: 'post',
            data: {name: name, price: price, details: details},
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {

                if(data.status=="true")
                    {
                        $("#addModal").modal("hide");
                        $('#addProductForm')[0].reset();
                        $('#success1').show();
                       // $('#table').load(location.href+'.table');
                       location.reload();

                    }
            },
            error: function(response) {
               errors=response.responseJSON.errors;
               $.each(errors,function(index,value){
                $('.errMsgContainer').append('<span class= "text-danger">'+value+'</span> </br>');
               })

            }
        });
    });
});
</script> --}}






{{--show city value in city form --}}

<script>
  // $(document).ready(function() {
  //   $('#updateModal').on('show.bs.modal', function(event) {
  //             // Fetch countries using AJAX
  //             $.ajax({
  //           url: "{{ LaravelLocalization::localizeURL(route('countries.index')) }}",
  //           method: "GET",
  //           dataType: "json",
  //           success: function(data) {
  //               // Populate the select dropdown with countries
  //               $('#up_country_id').empty(); // Clear existing options
  //               $.each(data, function(index, country) {
  //                   $('#up_country_id').append('<option value="' + country.id + '">' + country.name + '</option>');
  //               });

  //               // Set the selected country for the city in the dropdown
  //               let selectedCountryId = $('#up_country_id').data('selected-country-id'); // Assuming you have the country_id for the city
  //               $('#up_country_id').val(selectedCountryId);
  //           },
  //           error: function(response) {
  //               console.log('Error fetching countries: ' + response);
  //           }
  //       });
  //   });

  $(document).on("click", '.update_city_form', function() {
    let id = $(this).data('id');
    let name_en = $(this).data('name_en');
    let name_ar = $(this).data('name_ar');
    let district_en = $(this).data('district_en');
    let district_ar = $(this).data('district_ar');
    let population = $(this).data('population');
    let countrycode = $(this).data('countrycode');



    $('#up_id').val(id);
    $('#up_name_en').val(name_en);
    $('#up_name_ar').val(name_ar);
    $('#up_district_en').val(district_en);
    $('#up_district_ar').val(district_ar);
    $('#up_population').val(population);
    $('#up_CountryCode').val(countrycode);


});



$(document).on("click", ".update_city", function (e) {
    e.preventDefault();
    let id = $('#up_id').val();
    let up_name_en = $('#up_name_en').val();
    let up_name_ar = $('#up_name_ar').val();
    let up_district_ar = $('#up_district_ar').val();
    let up_district_en = $('#up_district_en').val();
    let up_CountryCode = $('#up_CountryCode').val();
    let up_population = $('#up_population').val();
    // let up_country_id = $('#up_country_id').val();


    $.ajax({
      url: "{{ route('cities.update', ['city' => ':id']) }}".replace(':id', id),
      method:"put",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        data: {
            id: id,
            name_en: up_name_en,
            name_ar: up_name_ar,
            district_en: up_district_en,
            district_ar: up_district_ar,
            CountryCode: up_CountryCode,
            population: up_population,

        },

        dataType: "json",
        success: function (data) {
            // console.log('AJAX request successful:', data);
            // console.log(data);
            $('#updateModal').modal('hide');
            alert('City updated successfully');
            location.reload(true);
        },
        error: function (response) {
            errors = response.responseJSON.errors;
            $.each(errors, function (index, value) {
                $('.errMsgContainer').append('<span class="text-danger">' + value + '</span> </br>');
            });
        }
    });
});

</script>
