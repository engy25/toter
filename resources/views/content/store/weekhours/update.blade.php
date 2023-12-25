<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Modal -->
<div class="modal fade" id="updateWeekhourModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <form action="" method="POST" id="updateWeekhourForm">
    @csrf
    <input type="hidden" id="up_id">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateModalLabel">Update Weekhour</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>



          <div class="form-group">
            <label for="fromtime">From Time (24-hour format)</label>
            <input type="time" name="upfromtime" id="upfromtime" class="form-control" required>
            <span class="text-danger error-message" id="error_upfromtime"></span>
          </div>
<br>
          <div class="form-group">
            <label for="uptotime">To Time (24-hour format)</label>
            <input type="time" name="uptotime" id="uptotime" class="form-control" required>
            <span class="text-danger error-message" id="error_uptotime"></span>
          </div>




        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary update_weekhour">Update changes</button>
        </div>
      </div>
    </div>
  </form>
</div>
