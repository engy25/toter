<?php
$i=0;
?>

<table id="data-table2" class="table border p-0 text-nowrap mb-0">
  <thead class="tabel-row-heading text-dark">
    <tr style="background:#f4f5f7">
      <th class="fw-semibold border-bottom">ID</th>
      <th class="fw-semibold border-bottom">{{ trans('words.name') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.image') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.tag') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.price') }}</th>
      <th class="fw-semibold border-bottom">{{ trans('words.avgRating') }}</th>
      <th class="bg-transparent fw-semibold border-bottom">Action</th>
    </tr>
  </thead>
  <tbody>
    @forelse($items as $item)
    <tr>
      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $i++ }}</span>
      </td>

      <td>
        <span class="text-dark fs-13 fw-semibold">
          @if ($item->translations->isNotEmpty())
          {{ $item->translations[0]->name }}
          @else
          {{ $item->name }}
          @endif
        </span>
      </td>

      <td>
        <img src="{{ asset($item->image) }}" alt="item Image" style="height: 50% ; width:50%" class="img-fluid">
      </td>

      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $item->category->name }}</span>

      </td>

      <td>
        <span class="text-dark fs-13 fw-semibold">{{ $item->price }}</span>
      </td>

      <td>
        <div class="d-flex align-items-center border-bottom-0">
          @if($item->avg_rating==0)
          <span class="fa fa-star checked">0</span>
          @else
          <span class="fa fa-star checked">{{ $item->avg_rating }}</span>
          @endif
        </div>
      </td>


      <td class="center align-middle">
        <div class="btn-group">

          <a href="{{ route('items.edit', $item->id) }}"
            class="btn bg-info-transparent d-flex align-items-center justify-content-center">
            <i style="font-size: 20px;" class="fe fe-edit text-info "></i></a>
          <a href="{{ LaravelLocalization::localizeURL(route('items.edit', $item->id)) }}"
            class="btn btn-info btn-icon py-1 me-2"
            data-id="{{ $item->id }}" data-name_en="{{ $item->translations()->where(" locale","en")->first()->name }}"
            data-name_ar="{{$item->translations()->where("locale","ar")->first()->name }}"
            data-Section_name="{{ $item->section->name }}" data-section_id="{{ $item->section->id }}" title="Edit"
            style="width: 100px; height: 40px;">
            {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
          </a>

          <a href="{{ route('items.show', $item->id) }}" class="btn btn-success show-item"
            style="width: 100px; height: 40px;">
            <i class="bi bi-eye"></i> {{ trans('words.show') }}
          </a>&nbsp;&nbsp;

          <button type="button" class="btn btn-danger delete-item" data-id="{{ $item->id }}"
            style="width: 100px; height: 40px;">
            <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
          </button>
        </div>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="8" class="text-center">No Items found for this store.</td>
    </tr>
    @endforelse
  </tbody>


</table>
{{-- {!! $cities->links() !!} --}}
<div class="mt-4">
  @if ($items->lastPage() > 1)
  {{ $items->links('pagination.simple-bootstrap-4') }}
  @endif
</div>
