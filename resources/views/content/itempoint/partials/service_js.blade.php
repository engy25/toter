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






{{-- image to apear when add side --}}

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
// Update image preview when a file is selected
$('#sideImage').change(function () {
var input = this;
var reader = new FileReader();

reader.onload = function (e) {
    $('#sideImage-preview').attr('src', e.target.result);
};

reader.readAsDataURL(input.files[0]);
});
});
</script>
{{-- ------------------------------------------------------------------- --}}












{{-- ////////////////////////////////////////**add Service///////////////////////////////////--}}


<script>
  $(document).ready(function(){
    // console.log('Document is ready.');
    $(document).on("click", '.add_service', function(e){
    e.preventDefault();
    let item_id =  $('#item_id').val();
    let store_id = $('#store_id').val();
    let name_en = $('#namesen').val();
    let name_ar= $('#namesar').val();
    console.log(name_ar);
    console.log(name_en);

    var formData = new FormData();
    formData.append('name_en', name_en);
    formData.append('name_ar', name_ar);
    formData.append('store_id', store_id);
    formData.append('item_id', item_id);

    console.log(formData);
    $('.errMsgContainer').empty();
    // Clear previous error messages

    $.ajax({

      url: "{{ route('itempointservices.store') }}",
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
      $("#addServiceModal").modal("hide");
      $('#addServiceForm')[0].reset();
      $('#table-service').load(location.href+' #table-service');
      $('#serviceadd').show();
      /* hide success message after 4 seconds */
       setTimeout(function() {

        $('#serviceadd').hide();
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



{{-- -------------------------------------------------------------}}





{{-- //////////////////////////////DElete side////////////////////////////// --}}

<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

  $(document).on('click', '.delete-service', function (e) {
  $('.errMsgContainer').empty(); // Clear previous error messages
    e.preventDefault();

    e.stopPropagation();
    var service_id = $(this).data('id');



    if (confirm("Are you sure you want to delete this Service?")) {
        $.ajax({
            url: '/itemservices/' + service_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                itemservice: service_id,

            },
            success: function (data) {
              ///
              if (data.status === true) {
                $('#table-service').load(location.href + ' #table-service');
                $('#servicedelete').show();
                setTimeout(function () {
                  $('#servicedelete').hide();
                }, 2000);
              } else if (data.status === false) {
                 // size could not be deleted due to relationships
                alert(data.msg);
              } else if (data.status === 403) {
                 // size deletion forbidden due to relationships
                alert(data.msg);

              }
            },
            error: function (data) {
              alert('Deletion of this Service is forbidden as it is related to other tables.');
                console.log(data);
                if(data.status==false){
                  alert('Deletion of this Service is forbidden as it is related to other tables.');
                }
                if (data.status !== 500) {
                    alert('An error occurred while deleting the Service.');
                }
            }
        });
    }
});


</script>

{{-- -------------------------------------------------------------- --}}
