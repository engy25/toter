<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Modal -->
<div class="modal fade" id="dailyCalculationModal" tabindex="-1" aria-labelledby="dailyCalculationModal"
  aria-hidden="true">
  <form action="" method="POST" id="add_daily_cal_form">
    @csrf

    <input type="hidden"  id="arrivalTimeId" value={{ $id }} >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addCancelModalLabel">Add Daily Calculation</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>


          <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" step="0.01" id="price">
            <!-- The "step" attribute is set to "0.01" to allow decimal values -->
            <span class="text-danger error-message" id="error_price"></span>
          </div>




          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary add_daily_cal">Add </button>
          </div>
        </div>
      </div>
  </form>
</div>
