<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->

<div class="card invoice-preview-card">

<div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModal" aria-hidden="true">
  <form action="" method="POST" id="addScheduleForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h1 class="modal-title fs-5" id="aaddModalLabel">Add New Delivery Schedule</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>

          <input type="hidden" name="delivery_id" id="delivery_id" value="{{ $delivery->id }}">

          <div class="form-group">
            <label for="day">Day</label>
            <select name="scheduleday" id="scheduleday" class="form-control" required>

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



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary add_schedule">Save changes</button>
        </div>
      </div>
    </div>
  </form>

</div>
