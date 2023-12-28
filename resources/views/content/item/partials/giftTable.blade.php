<h5 class="my-3 text-center" style="color: black"> {{ $title }}</h5>
<!-- Add button to create a new drink -->
<div class="text-center mb-3">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <a href="{{ route('gifts.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGiftModal">Add New Gift </a>
</div>
<div class="table-responsive border-top" id ="table-gift">
  <table class="table m-0">
    <thead>
      <tr>
        <th> Name</th>
        <th>Image</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($gifts as $gift)
        <tr>
          <td>{{ $gift->name }}</td>
          <td>
            <img src="{{ asset($gift->image) }}" alt="Ingredient Image" style="height: 20%; width:20%"
              class="img-fluid">
          </td>


          <td class="center align-middle">
            <div class="btn-group">

              <button type="button" class="btn btn-danger delete-gift" data-id="{{ $gift->id }}"
                style="width: 100px; height: 40px;">
                <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
              </button>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center">No Gift found for this Item.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
  @include('content.gift.add_gift_model')
</div>
