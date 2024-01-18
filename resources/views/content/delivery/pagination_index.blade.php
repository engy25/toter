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
            <th class="fw-semibold border-bottom">{{ trans('words.fname') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.image') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.email') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.phone') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.active') }}</th>
            <th class="bg-transparent fw-semibold border-bottom">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($deliveries as $delivery)
          <tr>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $i++ }}</span>
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold">

                {{ $delivery->fname }}

              </span>
            </td>

            <td>
              <img src="{{ asset($delivery->image) }}" alt="Delivery Image" style="height: 50% ; width:50%"
                class="img-fluid">
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $delivery->email }}</span>
            </td>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $delivery->country_code }} {{ $delivery->phone }}</span>
            </td>
            <td>
              @if($delivery->is_active==1)
              <span class="badge text-white bg-success fw-semibold fs-11">Active</span>
              @else
              <span class="badge text-white bg-danger fw-semibold fs-11">Not Active</span>
              @endif
            </td>
            <td class="center align-middle">
              <div class="btn-group">
                <a href="{{ route('deliveries.edit', $delivery->id) }}"
                  class="btn bg-info-transparent d-flex align-items-center justify-content-center">
                  <i style="font-size: 20px;" class="fe fe-edit text-info "></i></a>
                <a href="{{ LaravelLocalization::localizeURL(route('deliveries.edit', $delivery->id)) }}"
                  class="btn btn-info btn-icon py-1 me-2 "
                  data-id="{{ $delivery->id }}" title="Edit"
                  style="width: 100px; height: 40px;">
                  {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
                </a>
                {{-- @can('show Delivery', $delivery) --}}
                <a href="{{ route('deliveries.show', $delivery->id) }}" class="btn btn-success show-delivery"
                  style="width: 100px; height: 40px;">
                  <i class="bi bi-eye"></i> {{ trans('words.show') }}
                </a>&nbsp;&nbsp;
                {{-- @endcan --}}


              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{-- {!! $cities->links() !!} --}}
      <div class="mt-4">
        @if ($deliveries->lastPage() > 1)
        {{ $deliveries->links('pagination.simple-bootstrap-4') }}
        @endif
      </div>
