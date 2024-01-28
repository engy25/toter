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






{{-- to add weekhours to the delivery --}}
<script>
  let deliveryId = 1;

  function addDelivery() {
    const container = document.getElementById('deliveriesContainer');

    const deliveryDiv = document.createElement('div');
    deliveryDiv.className = 'deliveries mb-3';

    function createInput(type, name, placeholder, step) {
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


  // Select day_id
const dayIdSelect = document.createElement('select');

dayIdSelect.className = 'form-control';
dayIdSelect.name = `deliveries[${deliveryId}][day_id]`;

// Use Ajax to fetch the days from the server
fetch('/get-days')  // Replace '/get-days' with your actual endpoint
  .then(response => response.json())
  .then(data => {
    data.forEach(day => {
      const option = document.createElement('option');
      option.value = day.id;
      option.textContent = day.name;
      dayIdSelect.appendChild(option);
    });
  })
  .catch(error => console.error('Error fetching days:', error));

deliveryDiv.appendChild(dayIdSelect);
deliveryDiv.appendChild(document.createElement('br'));

    // Input for from_time
    deliveryDiv.appendChild(createInput('time', `deliveries[${deliveryId}][from_time]`, 'From Time'));
    deliveryDiv.appendChild(document.createElement('br'));

    // Input for to_time
    deliveryDiv.appendChild(createInput('time', `deliveries[${deliveryId}][to_time]`, 'To Time'));
    deliveryDiv.appendChild(document.createElement('br'));

    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-danger';
    removeButton.textContent = 'Remove WeekHour';
    removeButton.onclick = function () {
      container.removeChild(deliveryDiv);
    };

    deliveryDiv.appendChild(removeButton);

    container.appendChild(deliveryDiv);
    deliveryId++;
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
