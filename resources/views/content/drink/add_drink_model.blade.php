<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addDrinkModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addDrinkForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="aaddModalLabel">Add Drink</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>


          <input type="hidden" name="item_id" id="item_id" value="{{ $item->id }}">

          <input type="hidden" name="store_id" id="store_id" value="{{ $item->store_id }}">

          <div class="form-group">
            <label for="drinks">Drinks</label>
            <select name="drinks[]" id="drinks" class="form-control" multiple="multiple">
              @forelse($drinks as $drink)
                <option value="{{ $drink->id }}">{{ $drink->name }}</option>
              @empty
                <option value="" disabled>No Drinks available</option>
              @endforelse
            </select>
          </div>



          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary add_drink">Save changes</button>
          </div>
        </div>
      </div>
  </form>
</div>
