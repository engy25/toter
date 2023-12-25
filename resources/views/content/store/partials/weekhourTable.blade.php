<div class="text-center mb-3">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <a href="{{ route('weekhours.create') }}" class="btn btn-primary" data-bs-toggle="modal"
    data-bs-target="#addweekhourModal">Add New WeekHour </a>
</div>

<h5 class="my-3 text-center" style="color: black">Week Hours</h5>
<div class="table-responsive border-top" id="data-week">
  <table class="table m-0">
    <thead>
      <tr>
        <th>Day Name</th>
        <th>From</th>
        <th>To</th>

        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($weekhours as $weekhour)
      <tr>
        <td>{{ $weekhour->day->name }}</td>
        <td>{{ $weekhour->from->format('h:i A') }}</td>
        <td>{{ $weekhour->to->format('h:i A') }}</td>
        <td class="center align-middle">
          <div class="btn-group">
            <a href="{{ route('weekhours.edit', $weekhour->id) }}"
              class="btn bg-info-transparent d-flex align-items-center justify-content-center">
              <i style="font-size: 20px;" class="fe fe-edit text-info "></i>
            </a>
            <a href="{{ LaravelLocalization::localizeURL(route('weekhours.edit', $weekhour->id)) }}"
              class="btn btn-info btn-icon py-1 me-2 update_weekhour_form" data-bs-toggle="modal"
              data-bs-target="#updateWeekhourModal" data-id="{{ $weekhour->id }}" data-day_id="{{ $weekhour->day_id }}" data-store_id="{{ $weekhour->store_id }}"
              data-days="{{ $days }}" data-from="{{ $weekhour->from }}" data-to="{{ $weekhour->to }}"


              title="Edit" style="width: 100px; height: 40px;">
              {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
            </a>
            {{-- @include("content.store.partials.updateweekhour",['id' => $weekhour->id,'day_id' => $weekhour->day_id]) --}}
            <button type="button" class="btn btn-danger delete-weekhour" data-id="{{ $weekhour->id }}"
              style="width: 100px; height: 40px;">
              <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
            </button>
          </div>
        </td>
        {{-- @include("content.store.partials.weekhour_js") --}}
      </tr>
      @endforeach
    </tbody>

  </table>
  @include("content.store.weekhours.add_weekhour_model")
  @include("content.store.weekhours.update")
</div>
