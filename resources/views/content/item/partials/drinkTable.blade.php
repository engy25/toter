<h5 class="my-3 text-center" style="color: black"> {{ $title }}</h5>
<!-- Add button to create a new drink -->
<div class="text-center mb-3">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <a href="{{ route('drinks.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDrinkModal">Add New Drink </a>
</div>
<div class="table-responsive border-top" id="data-tabledrink2">
  <table class="table m-0">
    <thead>
      <tr>
        <th> Name</th>
        <th>Image</th>
        <th>Price</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($drinks as $drink)
        <tr>
          <td>{{ $drink->name }}</td>
          <td>
            <img src="{{ asset($drink->image) }}" alt="Ingredient Image" style="height: 20%; width:20%"
              class="img-fluid">
          </td>
          <td>{{ $drink->price }} {{ $item->currencyIsoCode }}</td>

          <td class="center align-middle">
           
              <button type="button" class="btn btn-danger delete-drink" data-id="{{ $drink->id }}"
                style="width: 100px; height: 40px;">
                <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
              </button>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center">No Drinks found for this Item.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
  @include('content.drink.add_drink_model',["drinks"=>$item->store->drinks()->get()])
</div>
