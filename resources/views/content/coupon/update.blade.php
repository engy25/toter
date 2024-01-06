<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Modal -->
<div class="modal fade" id="updateCouponModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <form action="" method="POST" id="updateCouponForm">
    @csrf
    <input type="hidden" id="up_id">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateModalLabel">Update Coupon</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3"></div>

          <div class="form-group">
            <label for="up_store_id">Store:</label>
            <select name="up_store_id" class="form-control" id="up_store_id">
              <!-- Options will be dynamically populated here using JavaScript -->
            </select>
            <span class="text-danger error-message" id="error_up_store_id"></span>
          </div>
          <br>
          <div class="form-group">
            <label for="is_active">Is Active:</label>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" name="is_active" id="is_active">
              <label class="form-check-label" for="is_active">Active</label>
            </div>
            <span class="text-danger error-message" id="error_is_active"></span>
          </div>

          <div class="form-group">
            <label for="up_code">Code:</label>
            <input type="text" name="up_code" class="form-control" id="up_code">
            <span class="text-danger error-message" id="error_up_code"></span>
          </div>

          <div class="form-group">
            <label for="updiscount_percentage">Discount Percentage:</label>
            <input type="number" class="form-control" name="updiscount_percentage" id="updiscount_percentage" step="0.01">
            <span class="text-danger error-message" id="error_updiscount_percentage"></span>
          </div>

          <div class="form-group">
            <label for="upmax_user_used_code">Max User Used Code:</label>
            <input type="number" class="form-control" name="upmax_user_used_code" id="upmax_user_used_code">
            <span class="text-danger error-message" id="error_upmax_user_used_code"></span>
          </div>

          <div class="form-group">
            <label for="upexpire_date">Expire Date:</label>
            <input type="date" class="form-control" name="upexpire_date" value="{{ now()->format('Y-m-d') }}" id="upexpire_date">
            <span class="text-danger error-message" id="error_upexpire_date"></span>
          </div>
        </div>




        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary update_coupon">Update changes</button>
        </div>
      </div>
    </div>
  </form>
</div>
