@extends('layouts/layoutMaster')

@section('title', 'Country List - Pages')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">

@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>

@endsection

<div class="alert alert-success" style="display: none;" id="success2">

  Country Updated Successfully
</div>

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Country /</span> List
</h4>

<!-- Invoice List Table -->
<!-- Invoice List Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table class="invoice-list-table table border-top">
      <thead class="tabel-row-heading text-dark">
        <tr style="background:#f4f5f7">
          <th></th>
          <th>#ID</th>

          <th>Name</th>
          <th>Region</th>
          <th class="text-truncate">Code</th>
          <th>localName</th>
          <th>Population</th>
          <th>CurrencyName</th>

          <th class="cell-fit">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($countries as $country)
        <tr>
          <td></td>
          <td>{{ $country->id }}</td>
          <td>{{ $country->name }}</td>
          <td>{{ $country->region }}</td>
          <td class="text-truncate">{{ $country->code }}</td>
          <td>{{ $country->localName }}</td>
          <td>{{ $country->population }}</td>
          <td>{{ $country->currency->name  }}</td>

          <td class="cell-fit">
            <div class="d-flex justify-content-center">



              <a href="{{ LaravelLocalization::localizeURL(route('countries.edit', $country->id)) }}"
                class="btn btn-info btn-icon py-1 me-2 update_country_form" data-bs-toggle="modal"
                data-bs-target="#updateModal" data-id="{{ $country->id }}" data-name_en="{{ $country->name_en }}"
                data-name_ar="{{ $country->name_ar }}" data-region_en="{{ $country->region_en }}"
                data-region_ar="{{ $country->region_ar }}" data-population="{{ $country->population }}"
                data-code="{{ $country->code }}" data-code2="{{ $country->code2 }}"
                data-localName_en="{{ $country->localName_en }}" data-continent="{{ $country->continent }}"
                data-GNPOld="{{ $country->GNPOld }}" data-currency_id="{{ $country->currency_id }}"
                data-lifeExpectancy="{{ $country->lifeExpectancy }}" data-GNP="{{ $country->GNP }}"
                data-IndepYear="{{ $country->IndepYear }}" data-surfaceArea="{{ $country->surfaceArea }}"
                data-capital="{{ $country->capital }}" data-HeadOfState="{{ $country->HeadOfState }}"
                data-governmentForm_en="{{ $country->governmentForm_en }}"
                data-governmentForm_ar="{{ $country->governmentForm_ar }}"
                data-localName_ar="{{ $country->localName_ar }}" title="Edit" style="width: 100px; height: 40px;">
                Edit <i class="bi bi-pencil-square fs-16"></i>
              </a>






              <button type="button" class="btn btn-danger delete-country" data-id="{{ $country->id }}">
                <span class="bi bi-trash me-1"></span>Delete
              </button>

              </a>

            </div>
          </td>






        </tr>
        @endforeach
      </tbody>
    </table>
    {{-- @include('content.city.update')
    @include('content.city.city_js') --}}
    <div class="mt-4">
      @if ($countries->lastPage() > 1)
      {{ $countries->links('pagination.default') }}
      @endif
    </div>

  </div>
</div>


<script>
  $.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
</script>
<script>
  $('.delete-country').on('click', function(e){
          e.preventDefault();
          var country_id = $(this).data('id');
          $.ajax({
              url: 'countries/' + country_id,
              type: 'DELETE',
              data: {
                  _token: '{{ csrf_token() }}',
                  country: country_id
              },
              success: function(data){
                  if (data.status) {
                      // Remove the row from the table
                      $('button.delete-country[data-id="' + data.id + '"]').closest('tr').remove();
                      // Show success message
                      alert(data.msg);
                  } else {
                      alert('An error occurred while deleting the Country.');
                  }
              },
              error: function(data){
                  alert('An error occurred while deleting the Country.');
              }
          });
      });

</script>

@endsection
