<h5 class="my-3 text-center" style="color: black"> {{ $title }}</h5>
<!-- Add button to create a new drink -->
<div class="text-center mb-3">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <a href="{{ route('itempointpreferences.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addpreferenceModal">Add New Preference </a>
</div>
<div class="table-responsive border-top" id="preference-table">
  <table class="table m-0">
    <thead>
      <tr>
        <th> Name</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($preferences as $preference)
        <tr>
          <td>{{ $preference->name }}</td>

          <td class="center align-middle">
            <div class="btn-group">


              <button type="button" class="btn btn-danger delete-preference" data-id="{{ $preference->id }}"
                style="width: 100px; height: 40px;">
                <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
              </button>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center">No  Preferences found for this Item.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
  @include('content.itempoint.partials.add_preference_model')
</div>
