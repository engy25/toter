<?php
$i=0;
?>
     <table id="data-table2" class="table border p-0 text-nowrap mb-0">
      <thead class="tabel-row-heading text-dark">
        <tr style="background:#f4f5f7">
          <th class="fw-semibold border-bottom">ID</th>
          <th class="fw-semibold border-bottom">{{ trans('words.name') }}</th>
          <th class="fw-semibold border-bottom">{{ trans('words.Region') }}</th>
          <th class="fw-semibold border-bottom">{{ trans('words.Code') }}</th>
          <th class="fw-semibold border-bottom">{{ trans('words.localName') }}</th>
          <th class="fw-semibold border-bottom">{{ trans('words.Population') }}</th>
          <th class="fw-semibold border-bottom">{{ trans('words.CurrencyName') }}</th>
          <th class="bg-transparent fw-semibold border-bottom">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($countries as $country)
        <tr>
          <td>{{ $i++ }}</td>
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
                <span class="bi bi-trash me-1"> {{ trans('words.edit') }}</span> <i class="bi bi-pencil-square fs-16"></i>
              </a>






              <button type="button" class="btn btn-danger delete-country" data-id="{{ $country->id }}">
                <span class="bi bi-trash me-1">{{ trans('words.delete') }}</span>
              </button>

              </a>

            </div>
          </td>






        </tr>
        @endforeach
      </tbody>
    </table>
{{-- {!! $cities->links() !!} --}}
    <div class="mt-4">
      @if ($countries->lastPage() > 1)
      {{ $countries->links('pagination.simple-bootstrap-4') }}
      @endif
    </div>
