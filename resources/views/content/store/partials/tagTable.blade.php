<br><br>
<h5 class="my-3 text-center" style="color:black">Tags</h5>
<div class="text-center mb-3">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <a href="{{ route('tags.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTagModal">Add New Tag </a>
</div>
<div class="table-responsive border-top"id="data-tabletag">
  <table class="table m-0">
    <thead>
      <tr>
        <th>Tag Name</th>
        <th>Tag Description</th>
        <th>Actions</th>

      </tr>
    </thead>
    <tbody>
      @forelse ($store->tags()->get() as $tag)
      <tr>
        <td>{{ $tag->name }}</td>
        <td>{{ $tag->description }}</td>
        <td class="center align-middle">
          <div class="btn-group">
            <a href="{{ route('tags.edit', $tag->id) }}"
              class="btn bg-info-transparent d-flex align-items-center justify-content-center">
              <i style="font-size: 20px;" class="fe fe-edit text-info "></i>
            </a>
            <a href="{{ LaravelLocalization::localizeURL(route('tags.edit', $tag->id)) }}"
              class="btn btn-info btn-icon py-1 me-2 update_tag_form" data-bs-toggle="modal"
              data-bs-target="#updateTagModal" data-id="{{ $tag->id }}"
              data-name_en="{{ $tag->translations()->where("locale","en")->first()->name }}"
              data-name_ar="{{$tag->translations()->where("locale","ar")->first()->name }}"
              data-description_en="{{ $tag->translations()->where("locale","en")->first()->description }}"
              data-description_ar="{{$tag->translations()->where("locale","ar")->first()->description }}"
               title="Edit"
              style="width: 100px; height: 40px;">
              {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
            </a>
            <button type="button" class="btn btn-danger delete-tag" data-id="{{ $tag->id }}"
              style="width: 100px; height: 40px;">
              <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
            </button>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="2" class="text-center">No tags found for this store.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@include('content.store.tags.add_tag_model')
@include('content.store.tags.update')
  </table>
</div>
