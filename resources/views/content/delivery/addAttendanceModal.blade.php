<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Modal -->
<div class="modal fade" id="addDeliveryArrivalTimeModal" tabindex="-1" aria-labelledby="addModalLabel"
  aria-hidden="true">
  <form action="" method="POST" id="add_delivery_arrival_time_form">
    @csrf

    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addDeliveryArrivalTimeModal">Delivery Arrival Time </h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>



          <div class="form-group">
            <label for="fromtime">From Time </label>
            <input type="time" name="fromTime" id="fromTime" class="form-control" required>
            <span class="text-danger error-message" id="error_fromTime"></span>
          </div>
          <br>





          <div class="form-group">
            <label for="totime">To Time (24-hour format)</label>
            <input type="time" name="toTime" id="toTime" class="form-control" required>
            <span class="text-danger error-message" id="error_toTime"></span>
          </div>


          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary add_delivery_arrival">Add </button>
          </div>
        </div>
      </div>
  </form>
</div>
<br>
