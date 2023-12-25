<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addAddonModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addAddonForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="aaddModalLabel">Add Addon</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>


          <input type="hidden" name="item_id" id="item_id" value="{{ $item->id }}">

          <input type="hidden" name="store_id" id="store_id" value="{{ $item->store_id }}">

          <div class="form-group">
            <label for="addons">Addon</label>
            <select name="addons[]" id="addons" class="form-control" multiple="multiple">
              @forelse($addons as $addon)
                <option value="{{ $addon->id }}">{{ $addon->name }}</option>
              @empty
                <option value="" disabled>No addons available</option>
              @endforelse
            </select>
          </div>



          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary add_addon">Save changes</button>
          </div>
        </div>
      </div>
  </form>
</div>
