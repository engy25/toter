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

































{{-- ////////////////////////////////////////**add Subsection///////////////////////////////////--}}


<script>
  $(document).ready(function(){
    // console.log('Document is ready.');
    $(document).on("click", '.add_drink', function(e){
    e.preventDefault();

    let item_id =  $('#item_id').val();

   let drinks =$('#drinks').val();
   if (typeof drinks === 'string') {
            drinks = drinks.split(',');
        }
   console.log(drinks);

    $('.errMsgContainer').empty();
    // Clear previous error messages


    $.ajax({

      url: "{{ route('itemdrinks.store') }}",
      method: 'post',
      data:{
        "item_id":item_id,
        "drinks":drinks,
      } ,
      dataType: "json",
      headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },


      success: function(data) {
      console.log(data);
      $('.errMsgContainer').empty(); // Clear previous error messages
      $("#addDrinkModal").modal("hide");
      $('#addDrinkForm')[0].reset();
      $('#data-tabledrink2').load(location.href+' #data-tabledrink2');
      $('#drinkadd').show();
      /* hide success message after 4 seconds */
       setTimeout(function() {

        $('#drinkadd').hide();
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



{{-- ////////////////////////////////////////**add subsection///////////////////////////////////--}}





{{-- //////////////////////////////DElete subsection////////////////////////////// --}}

<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

  $(document).on('click', '.delete-drink', function (e) {
  $('.errMsgContainer').empty(); // Clear previous error messages
    e.preventDefault();

    e.stopPropagation();
    var drink_id = $(this).data('id');
    let item_id =  $('#item_id').val();


    if (confirm("Are you sure you want to delete this Drink?")) {
        $.ajax({
            url: '/itemdrink/' + item_id+ '/'+ drink_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                 drink_id: drink_id,
                 item_id:  item_id
            },
            success: function (data) {
              ///
              if (data.status === true) {
                $('#data-tabledrink2').load(location.href + ' #data-tabledrink2');
                $('#drinkdelete').show();
                setTimeout(function () {
                  $('#drinkdelete').hide();
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
              alert('Deletion of this Drink is forbidden as it is related to other tables.');
                console.log(data);
                if(data.status==false){
                  alert('Deletion of this Drink is forbidden as it is related to other tables.');
                }
                if (data.status !== 500) {
                    alert('An error occurred while deleting the Drink.');
                }
            }
        });
    }
});


</script>


{{-- //////////////////////////////DElete subsection////////////////////////////// --}}
