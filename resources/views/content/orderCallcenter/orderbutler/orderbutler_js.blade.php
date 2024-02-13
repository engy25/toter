<!-- CSS files -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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


<script>
  $(document).ready(function() {
    $('#city_id').change(function() {
      var cityId = $(this).val();

      // Make an AJAX request to fetch districts for the selected city
      $.ajax({
        url: '/cities/districts/' + cityId,
        type: 'GET',
        success: function(data) {
          // Populate the district dropdown with the received data
          var options = '<option value="">Select District</option>';

          $.each(data, function(index, district) {
            var districtName = district.translations.length > 0 ? district.translations[0].name : district.name;
            options += '<option value="' + district.id + '">' + districtName + '</option>';
          });
          $('#district_id').html(options);
        },
        error: function(response) {
          console.error('Error fetching districts:', response);
        }
      });
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#tocity_id').change(function() {
      var cityId = $(this).val();

      // Make an AJAX request to fetch districts for the selected city
      $.ajax({
        url: '/cities/districts/' + cityId,
        type: 'GET',
        success: function(data) {
          // Populate the district dropdown with the received data
          var options = '<option value="">Select District</option>';

          $.each(data, function(index, district) {
            var districtName = district.translations.length > 0 ? district.translations[0].name : district.name;
            options += '<option value="' + district.id + '">' + districtName + '</option>';
          });
          $('#todistrict_id').html(options);
        },
        error: function(response) {
          console.error('Error fetching districts:', response);
        }
      });
    });
  });
</script>



<script>

  function toggleFormElements(){
    var orderType = document.getElementById('orderType').value;

    //Hide All Forms
    document.getElementById('addOrderForm').style.display = 'none';
    document.getElementById('addItemsForm').style.display = 'none';

    if(orderType=='1')
    {


      document.getElementById('addOrderForm').style.display = 'block';
    }else if(orderType='2'){
     
      document.getElementById('addItemsForm').style.display = 'block';

    }

  }

  let itemId = 1;
  // {{-- to add items --}}
function addItem() {
  const container = document.getElementById('itemsContainer');

  const itemDiv = document.createElement('div');
  itemDiv.className = 'items mb-3';

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

  // Item
  itemDiv.appendChild(createInput('text', `items[${itemId}][item]`,  'Item'));
  itemDiv.appendChild(document.createElement('br'));


   itemDiv.appendChild(document.createElement('br'));

    // add Item Image
  const imageInput = createInput('file', `items[${itemId}][image]`, 'Item Image');

  const imagePreview = document.createElement('img');

  imagePreview.id = `imagePreview${itemId}`;
  imagePreview.style.display = 'none';
  imagePreview.style.maxWidth = '200px';

  imageInput.addEventListener('change', function (event) {
    displayImagePreview(event, imagePreview);
  });

  itemDiv.appendChild(imageInput);
  itemDiv.appendChild(document.createElement('br'));
  itemDiv.appendChild(imagePreview);
  itemDiv.appendChild(document.createElement('br'));

  const removeButton = document.createElement('button');
  removeButton.type = 'button';
  removeButton.className = 'btn btn-danger';
  removeButton.textContent = 'Remove Item';
  removeButton.onclick = function () {
    container.removeChild(itemDiv);
  };

  itemDiv.appendChild(removeButton);

  container.appendChild(itemDiv);
  itemId++;
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


