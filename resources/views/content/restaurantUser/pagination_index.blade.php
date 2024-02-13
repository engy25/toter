<?php
$i=0;
?>
<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table id="data-table2" class="table border p-0 text-nowrap mb-0">
        <thead class="tabel-row-heading text-dark">
          <tr style="background:#f4f5f7">
            <th class="fw-semibold border-bottom">{{ trans('words.user') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.phone') }}</th>
            <th class="bg-transparent fw-semibold border-bottom">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr>

            <td class="sorting_1">
              <div class="d-flex align-items-center user-name">
                <div class="avatar-wrapper">
                  <div class="avatar avatar-sm me-3">
                    <img src="{{ $user->image }}" alt="Image" class="rounded-circle">
                  </div>
                </div>
                <div class="d-flex flex-column">
                  <span class="fw-semibold">{{ $user->fname }}</span>
                  <small class="text-muted">{{ $user->email }}</small>
                </div>
              </div>
            </td>


            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $user->country_code }} {{ $user->phone }}</span>
            </td>


            <td class="center align-middle">
              <div class="btn-group">
                <a href="{{ route('restaurantusers.edit', $user->id) }}"
                  class="btn bg-info-transparent d-flex align-items-center justify-content-center">
                  <i style="font-size: 20px;" class="fe fe-edit text-info "></i></a>
                <a href="{{ LaravelLocalization::localizeURL(route('restaurantusers.edit', $user->id)) }}"
                  class="btn btn-info btn-icon py-1 me-2 "
                  data-id="{{ $user->id }}" title="Edit"
                  style="width: 100px; height: 40px;">
                  {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
                </a>
                <button type="button" class="btn btn-danger delete-user" data-id="{{ $user->id }}"
                  style="width: 100px; height: 40px;">
                  <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
                </button>&nbsp;&nbsp;


              </div>
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>
      {{-- {!! $users->links() !!} --}}

