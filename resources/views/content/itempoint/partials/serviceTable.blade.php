<h5 class="my-3 text-center" style="color: black"> {{ $title }}</h5>
<!-- Add button to create a new drink -->
<div class="text-center mb-3">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <a href="{{ route('itempointservices.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">Add New Service </a>
</div>
<div class="table-responsive border-top" id="table-service">
  <table class="table m-0">
    <thead>
      <tr>
        <th> Name</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($services as $service)
        <tr>
          <td>{{ $service->name }}</td>



          <td class="center align-middle">
            <div class="btn-group">
              <button type="button" class="btn btn-danger delete-service" data-id="{{ $service->id }}"
                style="width: 100px; height: 40px;">
                <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
              </button>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center">No Services found for this Item.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
  @include('content.itempoint.partials.add_service_model')
</div>
