<table id="data-table2" class="table border p-0 text-nowrap mb-0">
  <thead class="tabel-row-heading text-dark">
    <tr style="background:#f4f5f7">
      <th class="fw-semibold border-bottom">ID</th>
      <th class="fw-semibold border-bottom">{{ trans('words.name') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.District') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.CountryCode') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.Population') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.CountryName') }}</th>

      <th class="bg-transparent fw-semibold border-bottom">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($cities as $city)
    <tr>
      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $i++ }}</span>
      </td>
      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $city->name }}</span>
      </td>
      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $city->district }}</span>
      </td>

      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $city->CountryCode}}</span>
      </td>

      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $city->population  }}</span>
      </td>

      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $city->country->name }}</span>
      </td>

      <td class="center align-middle">
        <div class="btn-group">
          <a href="{{ route('cities.edit', $city->id) }}"
            class="btn bg-info-transparent d-flex align-items-center justify-content-center">
            <i style="font-size: 20px;" class="fe fe-edit text-info "></i></a>&nbsp;
          <a href="{{ LaravelLocalization::localizeURL(route('cities.edit', $city->id)) }}"
            class="btn btn-info btn-icon py-1 me-2 update_city_form" data-bs-toggle="modal"
            data-bs-target="#updateModal" data-id="{{ $city->id }}" data-name_en="{{ $city->name_en }}"
            data-name_ar="{{ $city->name_ar }}" data-district_en="{{ $city->district_en }}"
            data-district_ar="{{ $city->district_ar }}" data-population="{{ $city->population }}"
            data-CountryCode="{{ $city->CountryCode }}" data-Country_name="{{ $city->country->name }}"
            data-Country_id="{{ $city->country->id }}" title="Edit" style="width: 100px; height: 40px;">
            {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
          </a>
          <button type="button" class="btn btn-danger delete-city" data-id="{{ $city->id }}">
            <span class="bi bi-trash me-1">{{ trans('words.delete') }}</span>
          </button>
        </div>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{!! $cities->render() !!}
