<!-- resources/views/content/subsection/header.blade.php -->

<div class="d-flex justify-content-between align-items-center">
  <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Subsection /</span> List
      <br>
  </h4>

  <div class="d-flex align-items-center">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <a href="{{ route('subsections.create') }}" class="btn btn-primary me-2" data-bs-toggle="modal"
          data-bs-target="#addsubsectionModal" title="{{ trans('words.add') }}">
          {{ trans('words.add') }}
      </a>

      <form class="d-flex" id="searchForm">
          <input class="form-control me-2" type="search" id="search" name="search"
              placeholder="{{ trans('words.search') }}" aria-label="Search" style="width: 950px;">
      </form>
  </div>
</div>
