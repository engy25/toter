<!-- create.blade.php -->
@extends('layouts.layoutMaster')

@section('title', 'Create Order')

@section('vendor-style')
<!-- Include your vendor styles here -->
@endsection

@section('page-style')
<!-- Include your page-specific styles here -->
<style>
  .card {
    margin-bottom: 15px;
  }

  .card img {
    width: 100%;
    max-height: 150px;
    object-fit: contain;


  }

  .options,
  .addingredients,
  .removeingredients,
  .drinks,
  .addons,
  .gifts,
  .sizes,
  .services,
  .preferences,
  .sides {
    display: flex;
    flex-direction: column;
  }

  .option,
  .addingredient,
  .removeingredient,
  .drink,
  .addon,
  .gift,
  .size,
  .service,
  .preference,
  .side {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }

  .option img,
  .addingredient img,
  .removeingredient img,
  .drink img,
  .addon img,
  .gift img,
  .size img,
  .service img,
  .preference img,
  .side img {
    width: 50px;
    max-height: 50px;
    margin-right: 10px;
    object-fit: cover;
  }

  .option label,
  .option p,
  .addingredient label,
  .addingredient p,
  .removeingredient label,
  .removeingredient p,
  .drink label,
  .drink p,
  .addon label,
  .addon p,
  .gift label,
  .gift p,
  .size label,
  .size p,
  .service label,
  .service p,
  .preference label,
  .preference p,
  .side label,
  .side p {
    margin: 0;
  }
</style>
@endsection

@section('vendor-script')
<!-- Include your vendor scripts here -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('page-script')
<style>
  [required]:invalid+label::after {
    content: ' *';
    color: red;
  }
</style>
@endsection

<div class="alert alert-success" style="display: none;" id="success">
  User Added Successfully
</div>

@section('content')
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Add New Order</h4>
  </div>
  <div class="card-body">
    @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form method="post" action="{{ route('orders.store', ['id' => $id->id]) }}" enctype="multipart/form-data">
      @csrf

      <div class="row mb-4">
        @foreach($store->items as $item)
        <div class="col-md-6 col-lg-4 mb-3">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title">{{ $item->name }}</h5>
              <h6 class="card-subtitle text-muted">{{ $item->description }}</h6>
            </div>
            <img class="img-fluid" src="{{ $item->image }}" alt="Item Image" />
            <div class="card-body">
              <p class="card-text">{{ $item->price }} {{ $item->currency }}</p>

              <!-- Quantity Input -->
              <div class="form-group">
                <label for="quantity{{ $item->id }}">Quantity:</label>
                <input type="number" class="form-control" id="quantity{{ $item->id }}"
                  name="quantities[{{ $item->id }}]" value="1" min="1">
              </div>

              <!-- Display Options Here -->
              @if($item->options && count($item->options) > 0)
              <div>
                <h4>Options</h4>
              </div>
              <div class="options">
                @foreach($item->options as $option)
                <div class="option">
                  <img src="{{ $option->image }}" alt="{{ $option->name }} Image" />
                  <label>{{ $option->name }}</label>&ensp;
                  <p>{{ $option->price }} {{ $item->currency }}</p>
                  <input type="checkbox" name="options[{{ $item->id }}][]" value="{{ $option->id }}">
                </div>
                @endforeach
              </div>
              @endif

              <!-- Display Add Ingredients Here -->
              @if($item->Addingredients && count($item->Addingredients) > 0)
              <div>
                <h4>Add Ingredients</h4>
              </div>
              <div class="addingredients">
                @foreach($item->Addingredients as $Addingredient)
                <div class="addingredient">
                  <img src="{{ $Addingredient->image }}" alt="{{ $Addingredient->name }} Image" />
                  <label>{{ $Addingredient->name }}</label>&ensp;
                  <p>{{ $Addingredient->price }} {{ $item->currency }}</p>
                  <input type="checkbox" name="addingredients[{{ $item->id }}][]" value="{{ $Addingredient->id }}">
                </div>
                @endforeach
              </div>
              @endif

              <!-- Display Remove Ingredients Here -->
              @if($item->Removeingredients && count($item->Removeingredients) > 0)
              <div>
                <h4>Remove Ingredients</h4>
              </div>
              <div class="removeingredients">
                @foreach($item->Removeingredients as $Removeingredient)
                <div class="removeingredient">
                  <img src="{{ $Removeingredient->image }}" alt="{{ $Removeingredient->name }} Image" />
                  <label>{{ $Removeingredient->name }}</label>&ensp;
                  <p>{{ $Removeingredient->price }} {{ $item->currency }}</p>
                  <input type="checkbox" name="removeingredients[{{ $item->id }}][]"
                    value="{{ $Removeingredient->id }}">
                </div>
                @endforeach
              </div>
              @endif

              <!-- Display Drinks Here -->
              @if($item->drinks && count($item->drinks) > 0)
              <div>
                <h4>Drinks</h4>
              </div>
              <div class="drinks">
                @foreach($item->drinks as $drink)
                <div class="drink">
                  <img src="{{ $drink->image }}" alt="{{ $drink->name }} Image" />
                  <label>{{ $drink->name }}</label>&ensp;
                  <p>{{ $drink->price }} {{ $item->currency }}</p>
                  <input type="checkbox" name="drinks[{{ $item->id }}][]" value="{{ $drink->id }}">
                </div>
                @endforeach
              </div>
              @endif

              <!-- Display Addons Here -->
              @if($item->addons && count($item->addons) > 0)
              <div>
                <h4>Addons</h4>
              </div>
              <div class="addons">
                @foreach($item->addons as $addon)
                <div class="addon">
                  <img src="{{ $addon->image }}" alt="{{ $addon->name }} Image" />
                  <label>{{ $addon->name }}</label>&ensp;
                  <p>{{ $addon->price }} {{ $item->currency }}</p>
                  <input type="checkbox" name="addons[{{ $item->id }}][]" value="{{ $addon->id }}">
                </div>
                @endforeach
              </div>
              @endif

              <!-- Display Sizes Here -->
              @if($item->sizes && count($item->sizes) > 0)
              <div>
                <h4>Sizes</h4>
              </div>
              <div class="sizes">
                @foreach($item->sizes as $size)
                <div class="size">
                  <label>{{ $size->name }}</label>&ensp;
                  <p>{{ $size->price }} {{ $item->currency }}</p>
                  <input type="checkbox" name="sizes[{{ $item->id }}][]" value="{{ $size->id }}">
                </div>
                @endforeach
              </div>
              @endif

              <!-- Display Services Here -->
              @if($item->services && count($item->services) > 0)
              <div>
                <h4>Services</h4>
              </div>
              <div class="services">
                @foreach($item->services as $service)
                <div class="service">
                  <label>{{ $service->name }}</label>&ensp;
                  <p>{{ $service->price }} {{ $item->currency }}</p>
                  <input type="checkbox" name="services[{{ $item->id }}][]" value="{{ $service->id }}">
                </div>
                @endforeach
              </div>
              @endif

              <!-- Display Preferences Here -->
              @if($item->preferences && count($item->preferences) > 0)
              <div>
                <h4>Preferences</h4>
              </div>
              <div class="preferences">
                @foreach($item->preferences as $preference)
                <div class="preference">
                  <label>{{ $preference->name }}</label>&ensp;
                  <p>{{ $preference->price }} {{ $item->currency }}</p>
                  <input type="checkbox" name="preferences[{{ $item->id }}][]" value="{{ $preference->id }}">
                </div>
                @endforeach
              </div>
              @endif

              <!-- Display Sides Here -->
              @if($item->sides && count($item->sides) > 0)
              <div>
                <h4>Sides</h4>
              </div>
              <div class="sides">
                @foreach($item->sides as $side)
                <div class="side">
                  <label>{{ $side->name }}</label>&ensp;
                  <p>{{ $side->price }} {{ $item->currency }}</p>
                  <input type="checkbox" name="sides[{{ $item->id }}][]" value="{{ $side->id }}">
                </div>
                @endforeach
              </div>
              @endif

              <!-- Display Gifts Here -->
              @if($item->gifts && count($item->gifts) > 0)
              <div>
                <h4>Gifts</h4>
              </div>
              <div class="gifts">
                @foreach($item->gifts as $gift)
                <div class="gift">
                  <label>
                    <img src="{{ $gift->image }}" alt="{{ $gift->name }} Image" />
                    {{ $gift->name }}
                    <input type="radio" name="gifts[{{ $item->id }}]" value="{{ $gift->id }}">
                  </label>
                </div>
                @endforeach
              </div>
              @endif

              <button type="button" class="btn btn-success" onclick="addItem({{ $item->id }})">Add</button>
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Add Item</button>
      </div>
    </form>
  </div>

</div>
@endsection

<script>
  function addItem(itemId) {

      // Get quantity for the current item
      var quantity = parseInt($('#quantity' + itemId).val());

      // Get all selected options for the current item
      var selectedOptions = [];
      $('input[name="options[' + itemId + ']"]:checked').each(function () {
          selectedOptions.push($(this).val());
      });
      console.log(quantity);

      // Create an object for the current item
      var itemObject = {
          id: itemId,
          quantity: quantity,
          price: {{ $item->price }}, // Replace this with the actual price of the item
          options: selectedOptions
      };

      // Append the item object to the "items" array
      $('<input>').attr({
          type: 'hidden',
          name: 'items[' + itemId + ']',
          value: JSON.stringify(itemObject)
      }).appendTo('form');

      // Append the selected options to the "options" array
      if (selectedOptions.length > 0) {
          $('<input>').attr({
              type: 'hidden',
              name: 'options[' + itemId + '][]',
              value: selectedOptions.join(',')
          }).appendTo('form');
      }

      // Optionally, you can display a message or perform other actions as needed

      // Example: Display an alert
      alert('Item added to the order!');

      // Optionally, submit the form programmatically
      // Uncomment the line below if you want to automatically submit the form after adding an item
      // $('form').submit();
  }
</script>
