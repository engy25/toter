<?php
$i=0;
?>

<table id="data-table2" class="table border p-0 text-nowrap mb-0">
  <thead class="tabel-row-heading text-dark">
    <tr style="background:#f4f5f7">
      <th class="fw-semibold border-bottom">ID</th>
      <th class="fw-semibold border-bottom">{{ trans('words.name') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.image') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.SectionName') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.avgRating') }}</th>
      <th class="bg-transparent fw-semibold border-bottom">Action</th>
    </tr>
  </thead>
  <tbody>

    @foreach($stores as $store)
    <tr>
      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $i++ }}</span>
      </td>

      <td>
        <span class="text-dark fs-13 fw-semibold">
          @if ($store->translations->isNotEmpty())
          {{ $store->translations[0]->name }}
          @else
          {{ $store->name }}
          @endif
        </span>
      </td>

      <td>
        <img src="{{ asset($store->image) }}" alt="store Image" style="height: 50% ; width:50%" class="img-fluid">
      </td>

      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $store->section->name }}</span>
      </td>

      <td>
        <div class="d-flex align-items-center border-bottom-0">
            @if($store->avg_rating==0)
            <span class="fa fa-star checked">0</span>
            @else
            <span class="fa fa-star checked">{{ $store->avg_rating }}</span>
            @endif
        </div>
    </td>


    <td class="center align-middle">
      <div class="btn-group">
        <a href="{{ route('cities.edit', $store->id) }}"
          class="btn bg-info-transparent d-flex align-items-center justify-content-center">
          <i style="font-size: 20px;" class="fe fe-edit text-info "></i></a>
        <a href="{{ LaravelLocalization::localizeURL(route('cities.edit', $store->id)) }}"
          class="btn btn-info btn-icon py-1 me-2 update_city_form" data-bs-toggle="modal"
          data-bs-target="#updateModal" data-id="{{ $store->id }}"
          data-name_en="{{ $store->translations()->where("locale","en")->first()->name }}"
          data-name_ar="{{$store->translations()->where("locale","ar")->first()->name }}"
          data-Section_name="{{ $store->section->name }}" data-section_id="{{ $store->section->id }}" title="Edit"
          style="width: 100px; height: 40px;">
          {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
        </a>

        <a  href="{{ route('stores.show', $store->id) }}" class="btn btn-success show-store"  style="width: 100px; height: 40px;">
          <i class="bi bi-eye"></i> {{ trans('words.show') }}
        </a>&nbsp;&nbsp;

      <button type="button" class="btn btn-danger delete-store" data-id="{{ $store->id }}" style="width: 100px; height: 40px;">
          <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
      </button>
      </div>
    </td>
  </tr>
    @endforeach
  </tbody>
</table>
{{-- {!! $cities->links() !!} --}}
<div class="mt-4">
  @if ($stores->lastPage() > 1)
  {{ $stores->links('pagination.simple-bootstrap-4') }}
  @endif
</div>
