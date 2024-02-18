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


          <td class="center align-middle">
            <div class="btn-group">

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



