
<?php
$i=0;
?>
<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table id="data-table2" class="table border p-0 text-nowrap mb-0">
        <thead class="tabel-row-heading text-dark">
          <tr style="background:#f4f5f7">
            <th class="fw-semibold border-bottom">ID</th>
            <th class="fw-semibold border-bottom">{{ trans('words.name') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.cityname') }}</th>

            <th class="bg-transparent fw-semibold border-bottom">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($districts as $district)
          <tr>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $i++ }}</span>
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold">
                @if ($district->translations->isNotEmpty())
                {{ $district->translations[0]->name }}
                @else
                {{ $district->name }}
                @endif
              </span>
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $district->city->name }}</span>
            </td>

            <td class="center align-middle">
              <div class="btn-group">
                <a href="{{ route('districts.edit', $district->id) }}"
                  class="btn bg-info-transparent d-flex align-items-center justify-content-center">
                  <i style="font-size: 20px;" class="fe fe-edit text-info "></i></a>&nbsp;
                <a href="{{ LaravelLocalization::localizeURL(route('districts.edit', $district->id)) }}"
                  class="btn btn-info btn-icon py-1 me-2 update_district_form" data-bs-toggle="modal"
                  data-bs-target="#updateDistrictModal" data-id="{{ $district->id }}"
                  data-name_en="{{ $district->translations()->where("locale","en")->first()->name }}"
                  data-name_ar="{{$district->translations()->where("locale","ar")->first()->name }}"
                  data-City_name="{{ $district->city->name }}" data-city_id="{{ $district->city->id }}" title="Edit"
                  style="width: 100px; height: 40px;">
                  {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
                </a>
                <button type="button" class="btn btn-danger delete-district" data-id="{{ $district->id }}">
                  <span class="bi bi-trash me-1">{{ trans('words.delete') }}</span>
                </button>
              </div>
            </td>
          </tr>
          {{-- @include('content.district.update', ["city_id" => $district->city->id]) --}}
          @endforeach
        </tbody>
      </table>
      {{-- @include('content.district.district_js') --}}
      {{-- {!! $cities->links() !!} --}}
      <div class="mt-4">
        @if ($districts->lastPage() > 1)
        {{ $districts->links('pagination.simple-bootstrap-4') }}
        @endif
      </div>
