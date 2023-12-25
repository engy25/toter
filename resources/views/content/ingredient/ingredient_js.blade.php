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




























{{-- /***update Ingredient*// --}}

<script>
  $(document).on("click", ".close-btn", function (e) {
      $('.errMsgContainer').empty(); // Clear error messages when the form is closed
  });
</script>
<script>
  $(document).ready(function () {
      // Update image preview when a file is selected
      $('#up_image').change(function () {
          var input = this;
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#image-preview').attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
      });

      // Update image preview when modal is opened
      $('#updateIngredientModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget); // Button that triggered the modal
          var id = button.data('id');
          var nameEn = button.data('name_en');
          var nameAr = button.data('name_ar');
          var price = button.data('price');
          var add = button.data('add');
          var imageSrc = button.data('image');

          // Set the values in the form fields
          $('#up_id').val(id);
          $('#up_name_en').val(nameEn);
          $('#up_name_ar').val(nameAr);
          $('#up_price').val(price);
          $('#up_add').val(add);
          $('#image-preview').attr('src', imageSrc);
      });

      // Handle click on "Update changes" button
      $('.update_ingredient').click(function () {
          // Collect form data
          var formData = new FormData($('#updateIngredientForm')[0]);

          // Extract ingredient ID from data attribute
          var id = $('#up_id').val();

          // Perform AJAX request
          $.ajax({
              url: "{{ route('ingredients.update', ['ingredient' => ':id']) }}".replace(':id', id),
              method: "PUT",
              data: formData,
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              dataType: "json",
              contentType: false,
              processData: false,
              success: function (data) {
                  console.log(data);
                  if (data.status) {
                      console.log(data);
                      $('#updateIngredientModal').modal('hide');
                      // Optionally, you can update the table or show a success message
                  } else {
                      console.error('Failed to update Ingredient');
                  }
              },
              error: function (response) {
                  console.log(response.responseJSON);
                  $('.errMsgContainer').empty(); // Clear previous error messages
                  errors = response.responseJSON.errors;
                  $.each(errors, function (index, value) {
                      $('.errMsgContainer').append('<span class="text-danger">' + value + '</span></br>');
                  });
              }
          });
      });
  });
</script>









{{-- ////////////////////////////////////////**add Subsection///////////////////////////////////--}}


<script>
  $(document).ready(function(){
    // console.log('Document is ready.');
    $(document).on("click", '.add_ingredient', function(e){
    e.preventDefault();
    let item_id =  $('#item_id').val();
    let store_id = $('#store_id').val();
    let name_en = $('#name_en').val();
    let name_ar= $('#name_ar').val();
    let add=$('#add').val();
    let price=$('#price').val();
    let image = $('#image')[0].files[0];

    var formData = new FormData();
    formData.append('name_en', name_en);
    formData.append('name_ar', name_ar);
    formData.append('add', add);
    formData.append('price', price);
    formData.append('store_id', store_id);
    formData.append('item_id', item_id);
    formData.append('image', image);
    console.log(formData);
    $('.errMsgContainer').empty();
    // Clear previous error messages

    $.ajax({

      url: "{{ route('ingredients.store') }}",
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
      $("#addModal").modal("hide");
      $('#addIngredientForm')[0].reset();
      $('#data-tableing2').load(location.href+' #data-tableing2');
      $('#successingredient1').show();
      /* hide success message after 4 seconds */
       setTimeout(function() {

        $('#success1').hide();
       }, 2000); // 2000 milliseconds = 2 seconds

      $('.errMsgContainer').empty(); // Clear previous error messages
      },
      error: function(response) {
        console.log(response.responseJSON.errors);
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

$(document).on('click', '.delete-ingredient', function (e) {
    e.preventDefault();
    var ingredient_id = $(this).data('id');

    if (confirm("Are you sure you want to delete this Ingredient?")) {
        $.ajax({
            url: '{{ url("ingredients") }}/' + ingredient_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                 ingredient: ingredient_id
            },
            success: function (data) {
              console.log(data);
                if (data.status == true) {
                    // subsection was deleted successfully
                    $('#data-tableing2').load(location.href + ' #data-tableing2');

                    $('#successing3').show();
                    /* hide success message after 4 seconds */
                    setTimeout(function () {
                        $('#successing3').hide();
                    }, 2000);
                } else if (data.status == 422) {
                    // subsection could not be deleted due to relationships
                    alert('You cannot delete this ingredient as it is related to other tables.');
                } else if (data.status == 403) {
                    // subsection deletion forbidden due to relationships
                    alert('Deletion of this ingredient is forbidden as it is related to other tables.');
                }
            },
            error: function (data) {
                console.log(data);
                if (data.status !== 500) {
                    alert('An error occurred while deleting the ingredient.');
                }
            }
        });
    }
});


</script>

{{-- //////////////////////////////DElete subsection////////////////////////////// --}}
