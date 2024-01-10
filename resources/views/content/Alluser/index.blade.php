@extends('layouts.layoutMaster')

@section('title', 'User List - Pages')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

<style>
  .checked {
    color: orange;
  }
</style>

@section('content')
<div class="row g-4 mb-4">


  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Admin Counts</span>
            <div class="d-flex align-items-center my-1">
              <h4 class="mb-0 me-2"> @php
                echo App\Models\User::role(1)->count();
                @endphp</h4>

            </div>

          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>





  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Call Center Counts</span>
            <div class="d-flex align-items-center my-1">
              <h4 class="mb-0 me-2"> @php
                echo App\Models\User::role(15)->count();
                @endphp</h4>

            </div>

          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>





  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Vendors Counts</span>
            <div class="d-flex align-items-center my-1">
              <h4 class="mb-0 me-2"> @php
                echo App\Models\User::role(2)->count();
                @endphp</h4>

            </div>

          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>



  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Vendors Counts</span>
            <div class="d-flex align-items-center my-1">
              <h4 class="mb-0 me-2"> @php
                echo App\Models\User::role(5,"api")->count();
                @endphp</h4>

            </div>

          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>




  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>User Counts</span>
            <div class="d-flex align-items-center my-1">
              <h4 class="mb-0 me-2"> @php
                echo App\Models\User::role(3,"api")->count();
                @endphp</h4>

            </div>

          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>



  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>DataEntry Counts</span>
            <div class="d-flex align-items-center my-1">
              <h4 class="mb-0 me-2"> @php
                echo App\Models\User::role(4)->count();
                @endphp</h4>

            </div>

          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>


  <div class="col-xl-4 col-lg-5 col-md-3">
    <div class="card h-60 w-60">
      <div class="row h-70">
        <div class="col-sm-5">
          <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
            <img src="{{ asset('assets/img/illustrations/add-new-roles.png') }}" class="img-fluid mt-sm-4 mt-md-0"
              alt="add-new-roles" width="70">
          </div>
        </div>
        <div class="col-sm-7">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <div class="card-body text-sm-end text-center ps-sm-0">
            <a href="{{ route('users.create') }}" class="btn btn-primary mb-2 text-nowrap ">{{ trans('words.add_user')
              }}</a>

          </div>
        </div>
      </div>
    </div>
  </div>


</div>




<div class="card">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-3">Search Filter</h5>
    <div class="row">
      <div class="col-md-6">
        <!-- Role Select -->
        <div class="mb-3">
          <label for="role" class="form-label">{{ trans('words.role') }}</label>
          <select class="form-control" id="role" name="role">
            <option>Select Role</option>
            @foreach($roles as $role)
            <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="col-md-6">
        <!-- Status Select -->
        <div class="mb-3">
          <label for="status" class="form-label">{{ trans('words.status') }}</label>
          <select class="form-control" id="status" name="status">

            @foreach($statuses as $status)
            <option value="{{ $status["id"] }}">{{ $status["name"] }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="col-md-12">


        <form class="d-flex" id="searchForm">
          <input class="form-control me-2" type="search" id="search" name="search"
            placeholder="{{ trans('words.search') }}" aria-label="Search" style="width: 950px;">

        </form>

      </div>
    </div>
  </div>
  <div class="alert alert-success" style="display: none;" id="successUpdate">
    User Updated Successfully
  </div>

  <div class="table-responsive">
    <table id="data-table2" class="table border p-0 text-nowrap mb-0">
      <thead class="tabel-row-heading text-dark">
        <tr style="background:#f4f5f7">
          <th class="fw-semibold border-bottom">{{ trans('words.user') }}</th>
          <th class="fw-semibold border-bottom">{{ trans('words.role') }}</th>
          <th class="fw-semibold border-bottom">{{ trans('words.phone') }}</th>
          <th class="fw-semibold border-bottom">{{ trans('words.active') }}</th>
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
            @if($user->roles->isNotEmpty())

            @foreach($user->roles as $role)
            <span class="badge bg-primary">{{ $role->name }}</span>
            @endforeach
            @else
            <span class="text-muted">No roles assigned</span>
            @endif

          </td>

          <td>
            <span class="text-dark fs-13 fw-semibold">{{ $user->country_code }} {{ $user->phone }}</span>
          </td>
          <td>
            @if($user->is_active==1)
            <span class="badge text-white bg-success fw-semibold fs-11">Active</span>
            @else
            <span class="badge text-white bg-danger fw-semibold fs-11">Not Active</span>
            @endif
          </td>

          <td class="center align-middle">
            <div class="btn-group">
              <a href="{{ route('allusers.edit', $user->id) }}" class="btn bg-info-transparent">
                <i class="fe fe-edit text-info "></i>
              </a>
              <a href="{{ LaravelLocalization::localizeURL(route('allusers.edit', $user->id)) }}"
                class="btn btn-info btn-icon py-1 me-2" data-id="{{ $user->id }}" title="Edit"
                style="width: 100px; height: 40px;">
                {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
              </a>
              <a href="{{ route('allusers.show', $user->id) }}" class="btn btn-success show-delivery"
                style="width: 100px; height: 40px;">
                <i class="bi bi-eye"></i> {{ trans('words.show') }}
              </a>
            </div>

          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-4 d-flex justify-content-center">
      @if ($users->lastPage() > 1)
      {{ $users->links('pagination.simple-bootstrap-4') }}
      @endif
    </div>

  </div>
</div>
</div>

@include('content.user.user_js')
{{-- @include('content.city.update')
@include('content.city.add_city_model') --}}
{!! Toastr::message() !!}



@endsection
