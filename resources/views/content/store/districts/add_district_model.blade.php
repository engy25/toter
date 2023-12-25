<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addDistrictModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addDistrictForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="aaddModalLabel">Add District</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>


          <input type="hidden" name="store_id" id="store_id" value="{{ $store->id }}">

          <div class="form-group">
            <label for="city">Cities</label>
            <select name="city" id="city" class="form-control">
              @forelse($cities as $city)
              <option value="{{ $city->id }}">{{ $city->name }}</option>
              @empty
              <option value="" disabled>No Cities available</option>
              @endforelse
            </select>
          </div>

          <div class="form-group">
            <label for="district">Districts</label>
            <select name="district" id="district" class="form-control">
              <option value="" disabled>Select a city first</option>
            </select>
          </div>

          <div class="form-group">
            <label for="delivery">Delivery Charge</label>
            <input type="number" name="delivery" class="form-control" step="0.01" id="delivery" required>
            <span class="text-danger error-message" id="error_delivery"></span>
          </div><br>


          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary add_storedistrict">Save changes</button>
          </div>
        </div>
      </div>
  </form>


</div>
