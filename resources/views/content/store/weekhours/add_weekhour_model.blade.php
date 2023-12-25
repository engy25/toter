<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addweekhourModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addWeekhourForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="aaddModalLabel">Add WeekHour</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3"></div>

          <input type="hidden" name="store_id" id="store_id" value="{{ $store->id }}">

          <div class="form-group">
            <label for="day">Day</label>
            <select name="day" id="day" class="form-control" required>
              @forelse($daywhereNotInStore as $day)
                <option value="{{ $day->id }}">{{ $day->name }}</option>
              @empty
                <option value="" disabled>No Days available</option>
              @endforelse
            </select>
            <span class="text-danger error-message" id="error_day"></span>
          </div>

          <div class="form-group">
            <label for="fromtime">From Time (24-hour format)</label>
            <input type="time" name="fromtime" id="fromtime" class="form-control" required>
            <span class="text-danger error-message" id="error_fromtime"></span>
          </div>

          <div class="form-group">
            <label for="totime">To Time (24-hour format)</label>
            <input type="time" name="totime" id="totime" class="form-control" required>
            <span class="text-danger error-message" id="error_totime"></span>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary add_weekhour">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
