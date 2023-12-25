<br><br>
<h5 class="my-3 text-center"  style="color: black">{{ $title }}</h5>
<div class="text-center mb-3">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <a href="{{ route('storedistricts.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDistrictModal">Add New District </a>
</div>
<div class="table-responsive border-top" id="data-tabledistrict2">
  <table class="table m-0">
    <thead>
      <tr>
        <th>District Name</th>
        <th>City Name</th>
        <th>Delivery Charge</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($districts as $district)
      <tr>
        <td>{{ $district->name }}</td>
        <td>{{ $district->city->name }}</td>
        <td>{{$district->pivot->delivery_charge }} {{$store->defaultCurrency->isocode }}</td>
        <td class="center align-middle">
          <div class="btn-group">

            <button type="button" class="btn btn-danger delete-storedistrict" data-id="{{ $district->pivot->id }}"
              style="width: 100px; height: 40px;">
              <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
            </button>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @include('content.store.districts.add_district_model')
</div>
