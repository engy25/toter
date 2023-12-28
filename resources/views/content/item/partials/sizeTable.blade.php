<h5 class="my-3 text-center" style="color: black"> {{ $title }}</h5>
<!-- Add button to create a new drink -->
<div class="text-center mb-3">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <a href="{{ route('sizes.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSizeModal">Add New Size </a>
</div>
<div class="table-responsive border-top" id="table-size">
  <table class="table m-0">
    <thead>
      <tr>
        <th> Name</th>
        <th>Price</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($sizes as $size)
        <tr>
          <td>{{ $size->name }}</td>

          <td>{{ $size->price }} {{ $item->currencyIsoCode }}</td>

          <td class="center align-middle">
            <div class="btn-group">

              <button type="button" class="btn btn-danger delete-size" data-id="{{ $size->id }}"
                style="width: 100px; height: 40px;">
                <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
              </button>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center">No Sizes found for this Item.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
  @include('content.size.add_size_model')
</div>
