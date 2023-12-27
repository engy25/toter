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

{{--
to make the dropdoown store searchable
--}}


<script>
  $(document).ready(function() {
      $('#store_id').select2({
          placeholder: 'Select a Store',
          allowClear: true // Adds a clear button to easily reset the selection
      });
  });
</script>


<script>
  $(document).ready(function() {
      $('#tag_id').select2({
          placeholder: 'Select a Tag',
          allowClear: true // Adds a clear button to easily reset the selection
      });
  });
</script>



{{-- /** to fetch list of the data of tags and populate the dropdown*/// --}}
<script>
  $(document).ready(function(){
    $('#store_id').change(function () {
      let id = $(this).val();
      if (id) {
        $.ajax({
          url: "{{ route('store.tags', ['store_id' => ':id']) }}".replace(':id', id),
          method: 'GET',
          dataType: "json",
          success: function (data) {
            // populate the dropdown with the received tag data
            var options = '<option value=""> Select Tag </option>';
            $.each(data, function (index, tag) {
              var tagName = tag.translations ? tag.translations[0].name : tag.name;
              options += '<option value="' + tag.id + '">' + tagName + '</option>';
            });
            $('#tag_id').html(options);
          },
          error: function (response) {
            // Handle error if fetching tags fails
            console.error('Error fetching tags:', response);
          }
        });
      }
    });
  });
</script>





{{-- /** to fetch list of the data of drinks and populate the dropdown*/// --}}
<script>
  $(document).ready(function(){
    $('#store_id').change(function () {
      let id = $(this).val();
      if (id) {
        $.ajax({
          url: "{{ route('store.drinks', ['store_id' => ':id']) }}".replace(':id', id),
          method: 'GET',
          dataType: "json",
          success: function (data) {

            // populate the dropdown with the received tag data
            var options = '<option value=""> Select Drink </option>';
            $.each(data, function (index, drink) {
              var drinkName = drink.translations ? drink.translations[0].name : drink.name;
              options += '<option value="' + drink.id + '">' + drinkName + '</option>';
            });
            $('#drinks').html(options);
          },
          error: function (response) {
            // Handle error if fetching drinks fails
            console.error('Error fetching drinks:', response);
          }
        });
      }
    });
  });
</script>



{{-- /** to fetch list of the data of addons and populate the dropdown*/// --}}
<script>
  $(document).ready(function(){
    $('#store_id').change(function () {
      let id = $(this).val();
      if (id) {
        $.ajax({
          url: "{{ route('store.addons', ['store_id' => ':id']) }}".replace(':id', id),
          method: 'GET',
          dataType: "json",
          success: function (data) {

            // populate the dropdown with the received tag data
            var options = '<option value=""> Select Addon </option>';
            $.each(data, function (index, addon) {
              var addonName =  addon.name;
              options += '<option value="' + addon.id + '">' + addonName + '</option>';
            });
            $('#addons').html(options);
          },
          error: function (response) {
            // Handle error if fetching tags fails
            console.error('Error fetching addons:', response);
          }
        });
      }
    });
  });
</script>




{{-- to store gift in item --}}
<script>
  let giftId = 1;

  function addStoreGift() {
    const container = document.getElementById('giftsContainer');

    const giftDiv = document.createElement('div');
    giftDiv.className = 'gift mb-3';

    function createInput(type, name, placeholder) {
      const input = document.createElement('input');
      input.type = type;
      input.className = 'form-control';
      input.name = name;
      input.placeholder = placeholder;

      return input;
    }

    // Gift Name (English)
    giftDiv.appendChild(createInput('text', `gifts[${giftId}][name]`, 'Gift Name'));
    giftDiv.appendChild(document.createElement('br'));
    // Gift Image
    const imageInput = createInput('file', `gifts[${giftId}][image]`, 'Gift Image');
    const imagePreview = document.createElement('img');
    imagePreview.id = `imagePreview${giftId}`;
    imagePreview.style.display = 'none';

    imageInput.addEventListener('change', function (event) {
      displayImagePreview(event, imagePreview);
    });

    giftDiv.appendChild(imageInput);
    giftDiv.appendChild(document.createElement('br'));
    giftDiv.appendChild(imagePreview);

    // Add a line break after the image input field
    giftDiv.appendChild(document.createElement('br'));

    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-danger';
    removeButton.textContent = 'Remove Gift';
    removeButton.onclick = function () {
      container.removeChild(giftDiv);
    };

    giftDiv.appendChild(removeButton);

    container.appendChild(giftDiv);
    giftId++;
  }

  function displayImagePreview(event, imagePreview) {
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function () {
      imagePreview.src = reader.result;
      imagePreview.style.display = 'block';
    };

    reader.readAsDataURL(input.files[0]);
  }
</script>

{{-- ---------------------------------------- --}}


{{-- to store sizes --}}
<script>
  let sizeId = 1;

  function addSize() {
    const container = document.getElementById('sizesContainer');

    const sizeDiv = document.createElement('div');
    sizeDiv.className = 'size mb-3';

    function createInput(type, name, placeholder,step) {
      const input = document.createElement('input');
      input.type = type;
      input.className = 'form-control';
      input.name = name;
      input.placeholder = placeholder;
      if (step) {
        input.step = step;
      }
      return input;
    }

    // size Name (English)
    sizeDiv.appendChild(createInput('text', `sizes[${sizeId}][name_en]`,  'Name(English)'));
    sizeDiv.appendChild(document.createElement('br'));
     // size Name (Arabic)
     sizeDiv.appendChild(createInput('text', `sizes[${sizeId}][name_ar]`,  'Name(Arabic)'));
     sizeDiv.appendChild(document.createElement('br'));
     /** size price**/
     sizeDiv.appendChild(createInput('number', `sizes[${sizeId}][price]`,  'price' ,'0.01'));

     sizeDiv.appendChild(document.createElement('br'));


    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-danger';
    removeButton.textContent = 'Remove Size';
    removeButton.onclick = function () {
      container.removeChild(sizeDiv);
    };

    sizeDiv.appendChild(removeButton);

    container.appendChild(sizeDiv);
    sizeId++;
  }


</script>


{{-- --------------------------------------------------------------------------------------------------- --}}

{{-- to store ingredients --}}
<!-- Existing script -->
<script>
  let ingredientId = 1;

  function addIngredient() {
    const container = document.getElementById('ingredientsContainer');

    const ingredientDiv = document.createElement('div');
    ingredientDiv.className = 'ingredients mb-3';

    function createInput(type, name, placeholder, step, options) {
      if (type === 'select') {
        const select = document.createElement('select');
        select.className = 'form-control';
        select.name = name;

        // Add options to the select element
        options.forEach((option) => {
          const optionElement = document.createElement('option');
          optionElement.value = option.value;
          optionElement.text = option.text;
          select.appendChild(optionElement);
        });

        return select;
      } else {
        const input = document.createElement('input');
        input.type = type;
        input.className = 'form-control';
        input.name = name;
        input.placeholder = placeholder;
        if (step) {
          input.step = step;
        }
        return input;
      }
    }

    // Ingredient Name (English)
    ingredientDiv.appendChild(createInput('text', `ingredients[${ingredientId}][name_en]`, 'Name(English)'));
    ingredientDiv.appendChild(document.createElement('br'));

    // Ingredient Name (Arabic)
    ingredientDiv.appendChild(createInput('text', `ingredients[${ingredientId}][name_ar]`, 'Name(Arabic)'));
    ingredientDiv.appendChild(document.createElement('br'));

    // Ingredient Price
    ingredientDiv.appendChild(createInput('number', `ingredients[${ingredientId}][price]`, 'Price', '0.01'));
    ingredientDiv.appendChild(document.createElement('br'));

    // Select for add/remove
    const addRemoveOptions = [
      { value: '1', text: 'Add' },
      { value: '0', text: 'Remove' }
    ];
    ingredientDiv.appendChild(createInput('select', `ingredients[${ingredientId}][add_remove]`, 'Add/Remove', null, addRemoveOptions));
    ingredientDiv.appendChild(document.createElement('br'));

    // Add ingredient Image
    const imageInput = createInput('file', `ingredients[${ingredientId}][image]`, 'Ingredient Image');
    const imagePreview = document.createElement('img');

    imagePreview.id = `imagePreview${ingredientId}`;
    imagePreview.style.display = 'none';

    imageInput.addEventListener('change', function (event) {
      displayImagePreview(event, imagePreview);
    });

    ingredientDiv.appendChild(imageInput);
    ingredientDiv.appendChild(document.createElement('br'));
    ingredientDiv.appendChild(imagePreview);
    ingredientDiv.appendChild(document.createElement('br'));

    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-danger';
    removeButton.textContent = 'Remove Ingredient';
    removeButton.onclick = function () {
      container.removeChild(ingredientDiv);
    };

    ingredientDiv.appendChild(removeButton);

    container.appendChild(ingredientDiv);
    ingredientId++;
  }

  function displayImagePreview(event, imagePreview) {
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function () {
      imagePreview.src = reader.result;
      imagePreview.style.display = 'block';
    };

    reader.readAsDataURL(input.files[0]);
  }
</script>



{{-- to add service --}}
<script>
  let serviceId = 1;

  function addSerivice() {
    const container = document.getElementById('servicesContainer');

    const serviceDiv = document.createElement('div');
    serviceDiv.className = 'services mb-3';

    function createInput(type, name, placeholder,step) {
      const input = document.createElement('input');
      input.type = type;
      input.className = 'form-control';
      input.name = name;
      input.placeholder = placeholder;
      if (step) {
        input.step = step;
      }
      return input;
    }

    // service Name (English)
    serviceDiv.appendChild(createInput('text', `services[${serviceId}][name_en]`,  'Name(English)'));
    serviceDiv.appendChild(document.createElement('br'));
     // service Name (Arabic)
     serviceDiv.appendChild(createInput('text', `services[${serviceId}][name_ar]`,  'Name(Arabic)'));
     serviceDiv.appendChild(document.createElement('br'));
     /** service price**/
     serviceDiv.appendChild(createInput('number', `services[${serviceId}][price]`,  'price' ,'0.01'));

     serviceDiv.appendChild(document.createElement('br'));




    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-danger';
    removeButton.textContent = 'Remove Service';
    removeButton.onclick = function () {
      container.removeChild(serviceDiv);
    };

    serviceDiv.appendChild(removeButton);

    container.appendChild(serviceDiv);
    serviceId++;
  }


</script>
{{-- -------------------------------------------------------------------------------- --}}






{{-- to add preferences --}}
<script>
  let preferenceId = 1;

  function addPreference() {
    const container = document.getElementById('preferencesContainer');

    const preferenceDiv = document.createElement('div');
    preferenceDiv.className = 'preferences mb-3';

    function createInput(type, name, placeholder,step) {
      const input = document.createElement('input');
      input.type = type;
      input.className = 'form-control';
      input.name = name;
      input.placeholder = placeholder;
      if (step) {
        input.step = step;
      }
      return input;
    }

    // preference Name (English)
    preferenceDiv.appendChild(createInput('text', `preferences[${preferenceId}][name_en]`,  'Name(English)'));
    preferenceDiv.appendChild(document.createElement('br'));
     // preference Name (Arabic)
     preferenceDiv.appendChild(createInput('text', `preferences[${preferenceId}][name_ar]`,  'Name(Arabic)'));
     preferenceDiv.appendChild(document.createElement('br'));
     /** preference price**/
     preferenceDiv.appendChild(createInput('number', `preferences[${preferenceId}][price]`,  'price' ,'0.01'));

     preferenceDiv.appendChild(document.createElement('br'));



    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-danger';
    removeButton.textContent = 'Remove Preference';
    removeButton.onclick = function () {
      container.removeChild(preferenceDiv);
    };

    preferenceDiv.appendChild(removeButton);

    container.appendChild(preferenceDiv);
    preferenceId++;
  }


</script>
{{-- -------------------------------------------------------------------------------- --}}





{{-- to add options --}}
<script>
  let optionId = 1;

  function addOption() {
    const container = document.getElementById('optionsContainer');

    const optionDiv = document.createElement('div');
    optionDiv.className = 'options mb-3';

    function createInput(type, name, placeholder,step) {
      const input = document.createElement('input');
      input.type = type;
      input.className = 'form-control';
      input.name = name;
      input.placeholder = placeholder;
      if (step) {
        input.step = step;
      }
      return input;
    }

    // preference Name (English)
    optionDiv.appendChild(createInput('text', `options[${optionId}][name_en]`,  'Name(English)'));
    optionDiv.appendChild(document.createElement('br'));
     // preference Name (Arabic)
     optionDiv.appendChild(createInput('text', `options[${optionId}][name_ar]`,  'Name(Arabic)'));
     optionDiv.appendChild(document.createElement('br'));
     /** preference price**/
     optionDiv.appendChild(createInput('number', `options[${optionId}][price]`,  'price' ,'0.01'));

     optionDiv.appendChild(document.createElement('br'));

      // add ingredient Image
    const imageInput = createInput('file', `options[${optionId}][image]`, 'Option Image');

    const imagePreview = document.createElement('img');

    imagePreview.id = `imagePreview${optionId}`;
    imagePreview.style.display = 'none';

    imageInput.addEventListener('change', function (event) {
      displayImagePreview(event, imagePreview);
    });

    optionDiv.appendChild(imageInput);
    optionDiv.appendChild(document.createElement('br'));
    optionDiv.appendChild(imagePreview);
    optionDiv.appendChild(document.createElement('br'));

    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-danger';
    removeButton.textContent = 'Remove Option';
    removeButton.onclick = function () {
      container.removeChild(optionDiv);
    };

    optionDiv.appendChild(removeButton);

    container.appendChild(optionDiv);
    optionId++;
  }

  function displayImagePreview(event, imagePreview) {
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function () {
      imagePreview.src = reader.result;
      imagePreview.style.display = 'block';
    };

    reader.readAsDataURL(input.files[0]);
  }
</script>
{{-- -------------------------------------------------------------------------------- --}}




{{-- to add sides --}}
<script>
  let sideId = 1;

  function addSide() {
    const container = document.getElementById('sidesContainer');

    const sideDiv = document.createElement('div');
    sideDiv.className = 'sides mb-3';

    function createInput(type, name, placeholder,step) {
      const input = document.createElement('input');
      input.type = type;
      input.className = 'form-control';
      input.name = name;
      input.placeholder = placeholder;
      if (step) {
        input.step = step;
      }
      return input;
    }

    // side Name (English)
    sideDiv.appendChild(createInput('text', `sides[${sideId}][name_en]`,  'Name(English)'));
    sideDiv.appendChild(document.createElement('br'));
     // side Name (Arabic)
     sideDiv.appendChild(createInput('text', `sides[${sideId}][name_ar]`,  'Name(Arabic)'));
     sideDiv.appendChild(document.createElement('br'));
     /** side price**/
     sideDiv.appendChild(createInput('number', `sides[${sideId}][price]`,  'price' ,'0.01'));

     sideDiv.appendChild(document.createElement('br'));

      // add ingredient Image
    const imageInput = createInput('file', `sides[${sideId}][image]`, 'Side Image');

    const imagePreview = document.createElement('img');

    imagePreview.id = `imagePreview${sideId}`;
    imagePreview.style.display = 'none';

    imageInput.addEventListener('change', function (event) {
      displayImagePreview(event, imagePreview);
    });

    sideDiv.appendChild(imageInput);
    sideDiv.appendChild(document.createElement('br'));
    sideDiv.appendChild(imagePreview);
    sideDiv.appendChild(document.createElement('br'));

    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-danger';
    removeButton.textContent = 'Remove Side';
    removeButton.onclick = function () {
      container.removeChild(sideDiv);
    };

    sideDiv.appendChild(removeButton);

    container.appendChild(sideDiv);
    optionId++;
  }

  function displayImagePreview(event, imagePreview) {
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function () {
      imagePreview.src = reader.result;
      imagePreview.style.display = 'block';
    };

    reader.readAsDataURL(input.files[0]);
  }
</script>
{{-- -------------------------------------------------------------------------------- --}}






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
  $(document).on('click', '.delete-item', function (e) {
  $('.errMsgContainer').empty(); // Clear previous error messages
    e.preventDefault();

    e.stopPropagation();
    var item_id = $(this).data('id');

    if (confirm("Are you sure you want to delete this item?")) {
        $.ajax({
            url: 'items/' + item_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                item: item_id
            },
            success: function (data) {
              ///
              if (data.status === true) {
                $('#data-table2').load(location.href + ' #data-table2');
                $('#success3').show();
                setTimeout(function () {
                  $('#success3').hide();
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
              alert('Deletion of this item is forbidden as it is related to other tables.');
                console.log(data);
                if(data.status==false){
                  alert('Deletion of this item is forbidden as it is related to other tables.');
                }
                if (data.status !== 500) {
                    alert('An error occurred while deleting the item.');
                }
            }
        });
    }
});


</script>

{{-- //////////////////////////////DElete City////////////////////////////// --}}



{{-- /////////////////////////////Pagination item///////////////////////////////////// --}}

<script>
  $(document).on('click', '.pagination a', function(e){

  e.preventDefault();
  let page = $(this).attr('href').split('page=')[1];
  item(page);

});

function item(page) {
    $.ajax({
      url: "/pagination/paginate-item?page=" + page,
        type: 'get',
        success: function(data) {
          console.log(data);
            $('.table-responsive').html(data);
        },
        error: function (response) {
            // Handle error if fetching tags fails
            console.log(response.responseJSON);
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
    url:"{{ route('search.item') }}",
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

{{-- /////////////////////////////Display The subsections for the selected
section/////////////////////////////////////// --}}
