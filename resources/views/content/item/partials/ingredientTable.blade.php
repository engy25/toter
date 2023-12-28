<h5 class="my-3 text-center" style="color: black"> {{ $title }}</h5>
<!-- Add button to create a new drink -->
<div class="text-center mb-3">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <a href="{{ route('ingredients.create') }}"   class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add New {{ $title }} </a>
</div>
<div class="table-responsive border-top"  id="data-tableing2" >
  <table class="table m-0" >
    <thead>
      <tr>
        <th>Name</th>
        <th>Image</th>
        <th>Price</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($ingredients as $ingredient)
        <tr>
          <td>{{ $ingredient->name }}</td>
          <td>
            <img src="{{ asset($ingredient->image) }}" alt="Ingredient Image" style="height: 20%; width:20%"
              class="img-fluid">
          </td>
          <td>{{ $ingredient->price }} {{ $item->currencyIsoCode }}</td>

          <td class="center align-middle">
            <div class="btn-group">

              {{-- <a href="{{ LaravelLocalization::localizeURL(route('ingredients.edit', $ingredient->id)) }}"
                class="btn btn-info btn-icon py-1 me-2 update_ingredient_form" data-bs-toggle="modal"
                data-bs-target="#updateIngredientModal" data-id="{{ $ingredient->id }}"
                data-name_en="{{ $ingredient->translations()->where("locale","en")->first()->name }}" data-name_ar="{{ $ingredient->translations()->where("locale","ar")->first()->name }}"  data-image="{{ $ingredient->image }}" data-price={{ $ingredient->price }}  data-add= {{ $ingredient->add }}   title="Edit" style="width: 100px; height: 40px;">
                {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
              </a> --}}


              <button type="button" class="btn btn-danger delete-ingredient" data-id="{{ $ingredient->id }}"
                style="width: 100px; height: 40px;">
                <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
              </button>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center">No Ingredients found for this Item.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
  @include('content.ingredient.update')
</div>



