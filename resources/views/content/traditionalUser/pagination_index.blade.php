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
                <a href="{{ route('createStore.create', ['user' => $user->id]) }}" class="btn btn-success" title="Add Order">
                  Add Order
                </a>&nbsp;

                <a href="{{ route('create.order.butler', ['userId' => $user->id]) }}" class="btn btn-primary" title="Add Order Butler">
                  Add Order Butler
                </a>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{-- {!! $cities->links() !!} --}}

