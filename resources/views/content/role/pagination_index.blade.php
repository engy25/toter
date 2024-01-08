
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
            <th class="fw-semibold border-bottom">{{ trans('words.created_date') }}</th>
            <th class="fw-semibold border-bottom">{{ trans('words.guard') }}</th>
            <th class="bg-transparent fw-semibold border-bottom">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($roles as $role)
          <tr>
            <td>
              <span class="text-dark fs-13 fw-semibold">{{ $i++ }}</span>
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold"> {{ $role->name }}</span>
            </td>

            <td>
              <span class="text-dark fs-13 fw-semibold"> {{ $role->created_at->format('g:i A, F j, Y') }}</span>
            </td>

            <td>
              @if($role->guard_name=="web")
              <span class="text-dark fs-13 fw-semibold">Web</span>
              @else
              <span class="text-dark fs-13 fw-semibold">Mobile</span>
              @endif
            </td>

            <td class="center align-middle">
              <div class="btn-group">
                <a href="{{ route('roles.edit', $role->id) }}"
                  class="btn bg-info-transparent d-flex align-items-center justify-content-center">
                  <i style="font-size: 20px;" class="fe fe-edit text-info "></i></a>&nbsp;
                <a href="{{ LaravelLocalization::localizeURL(route('roles.edit', $role->id)) }}"
                  class="btn btn-info btn-icon py-1 me-2 update_role_form" data-bs-toggle="modal"
                  data-bs-target="#updateRoleModal" data-id="{{ $role->id }}" data-guard="{{ $role->guard_name }}"
                  data-name="{{ $role->name }}" title="Edit" style="width: 100px; height: 40px;">
                  {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
                </a>
                <button type="button" class="btn btn-danger delete-role" data-id="{{ $role->id }}">
                  <span class="bi bi-trash me-1">{{ trans('words.delete') }}</span>
                </button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{-- {!! $cities->links() !!} --}}
      <div class="mt-4">
        @if ($roles->lastPage() > 1)
        {{ $roles->links('pagination.simple-bootstrap-4') }}
        @endif
      </div>
