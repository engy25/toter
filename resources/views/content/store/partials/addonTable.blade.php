<h5 class="my-3 text-center" style="color: black"> {{ $title }}</h5>
<!-- Add button to create a new drink -->
<div class="text-center mb-3">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <a href="{{ route('adds.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addaddModal">Add New Addon </a>
</div>
<div class="table-responsive border-top"  id="data-tableaddon2">
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
      @forelse ($addons as $addon)
        <tr>
          <td>{{ $addon->name }}</td>
          <td>
            <img src="{{ asset($addon->image) }}" alt="Addon Image" style="height: 20%; width:20%"
              class="img-fluid">
          </td>
          <td>{{ $addon->price }} {{ $store->currencyIsoCode }}</td>

          <td class="center align-middle">
            <div class="btn-group">
              <a href="{{ route('addons.edit', $addon->id) }}"
                class="btn bg-info-transparent d-flex align-items-center justify-content-center">
                <i style="font-size: 20px;" class="fe fe-edit text-info "></i>
              </a>
              <a href="{{ LaravelLocalization::localizeURL(route('addons.edit', $addon->id)) }}"
                class="btn btn-info btn-icon py-1 me-2 update_city_form" data-bs-toggle="modal"
                data-bs-target="#updateModal" data-id="{{ $addon->id }}"
                {{-- data-name_en="{{ $addon->translations()->where("locale","en")->first()->name }}"
                data-name_ar="{{$addon->translations()->where("locale","ar")->first()->name }}" --}}
                data-image="{{ $addon->image }}" title="Edit"
                style="width: 100px; height: 40px;">
                {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
              </a>

              <button type="button" class="btn btn-danger delete-add" data-id="{{ $addon->id }}"
                style="width: 100px; height: 40px;">
                <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
              </button>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center">No Addons found for this Item.</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  @include('content.store.addons.add_addon_model')
</div>
