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
              <input type="checkbox" id="options[{{ $item->id }}][]" name="options[{{ $item->id }}][]"
                value="{{ $option->id }}">
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
