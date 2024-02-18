<h5 class="my-3 text-center" style="color: black"> {{ $title }}</h5>
<!-- Add button to create a new drink -->
<div class="text-center mb-3">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <a href="{{ route('itempointoptions.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOptionModal">Add New Option </a>
</div>
<div class="table-responsive border-top" id="table-option">
  <table class="table m-0">
    <thead>
      <tr>
        <th> Name</th>
        <th>Image</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($options as $option)
        <tr>
          <td>{{ $option->name }}</td>
          <td>
            <img src="{{ asset($option->image) }}" alt="option Image" style="height: 20%; width:20%"
              class="img-fluid">
          </td>

          <td class="center align-middle">
            <div class="btn-group">

              <button type="button" class="btn btn-danger delete-option" data-id="{{ $option->id }}"
                style="width: 100px; height: 40px;">
                <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
              </button>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center">No Options found for this Item.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
  @include('content.itempoint.partials.add_option_model')
</div>
