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



{{-- --------------------------------------------------------------------------------- --}}

<script>
  $(document).ready(function () {
    $('#search').on('input', function () {
        var url = window.location.href;
        var id = url.substring(url.lastIndexOf('/') + 1);

        var searchString = $(this).val();
        $.ajax({
            url: "{{ route('search.items', ['order' => ':id']) }}".replace(':id', id),
            type: 'GET',
            data: { search: searchString },
            success: function (response) {
                if (response.status === 'success') {
                    $('#search-results').html(response.html);
                } else {
                    $('#search-results').html('<p>No items found</p>');
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    });
});

</script>


{{-- --------------------------------------------------------------------------------- --}}


{{--to store the items and its related table by ajax--}}
<script>
  function addItem(itemId) {
    // Get the quantity
    var quantity = parseInt($('#quantity' + itemId).val());

    // Get the selected options
    var options = [];
    $("input[name='options[" + itemId + "][]']:checked").each(function() {
      options.push($(this).val());
    });

    // Get the selected ingredients
    var ingredients = [];
    $("input[name='addingredients[" + itemId + "][]']:checked").each(function() {
      ingredients.push($(this).val());
    });

    // Create the item object
    var item = {
      id: itemId,
      quantity: quantity,
      options: options,
      addingredients: ingredients
    };
    console.log(item);

    // AJAX request
    $.ajax({
      url: "{{ route('orders.store', ['id' => $id->id]) }}",
      type: "POST",
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
      data: { item: item },
      success: function(response) {
        console.log(response); // Handle the response from the server
      },
      error: function(xhr) {
        console.log(xhr.responseText); // Handle any errors
      }
    });
  }
</script>


{{-- --------------------------------------------------------------------------------- --}}
