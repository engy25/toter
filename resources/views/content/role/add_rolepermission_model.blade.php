@extends('layouts.layoutMaster')

@section('title', 'Assign Permission to the Role - Apps')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Assign Permission to the Role /</span>
        <br>
    </h4>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <!-- Your existing table or content goes here -->

            <!-- Form to assign permissions -->
            <form action="{{ route('rolePermissions.store', $role->id) }}" method="POST">
                @csrf

                <!-- Display all permissions with checkboxes -->
                <div class="form-check">
                  @foreach ($permissions as $permission)
                      <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                          @if ($role->hasPermissionTo($permission->name)) checked @endif>
                      <label class="form-check-label" for="permissions">{{ $permission->name }}</label><br>
                  @endforeach
              </div>

                <button type="submit" class="btn btn-primary mt-3">Assign Permissions</button>
            </form>
        </div>
    </div>
</div>

{!! Toastr::message() !!}

@endsection
