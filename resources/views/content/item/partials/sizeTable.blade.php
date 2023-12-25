<h5 class="my-3 text-center" style="color: black"> {{ $title }}</h5>
<!-- Add button to create a new drink -->
<div class="text-center mb-3">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <a href="{{ route('sizes.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add New Size </a>
</div>
<div class="table-responsive border-top">
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
              <a href="{{ route('sizes.edit', $size->id) }}"
                class="btn bg-info-transparent d-flex align-items-center justify-content-center">
                <i style="font-size: 20px;" class="fe fe-edit text-info "></i>
              </a>
              <a href="{{ LaravelLocalization::localizeURL(route('sizes.edit', $size->id)) }}"
                class="btn btn-info btn-icon py-1 me-2 update_size_form" data-bs-toggle="modal"
                data-bs-target="#updateModal" data-id="{{ $size->id }}"
                {{-- data-name_en="{{ $size->translations()->where("locale","en")->first()->name }}"
                data-name_ar="{{$size->translations()->where("locale","ar")->first()->name }}" --}}
                title="Edit"
                style="width: 100px; height: 40px;">
                {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
              </a>
              <a href="{{ route('sizes.show', $size->id) }}" class="btn btn-success show-item"
                style="width: 100px; height: 40px;">
                <i class="bi bi-eye"></i> {{ trans('words.show') }}
              </a>&nbsp;&nbsp;
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
</div>
