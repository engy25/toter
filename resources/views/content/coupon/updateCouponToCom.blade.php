<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Modal -->
<div class="modal fade" id="updateCouponToComModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <form action="" method="POST" id="updateCouponToComForm">
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
            <label for="isActive">Is Active:</label>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" name="isActive" id="isActive">
              <label class="form-check-label" for="isActive">Active</label>
            </div>
            <span class="text-danger error-message" id="error_isActive"></span>
          </div>

          <div class="form-group">
            <label for="upcode">Code:</label>
            <input type="text" name="upcode" class="form-control" id="upcode">
            <span class="text-danger error-message" id="error_upcode"></span>
          </div>




          <div class="form-group">
            <label for="up-max_user_used_code">Max User Used Code:</label>
            <input type="number" class="form-control" name="up-max_user_used_code" id="up-max_user_used_code">
            <span class="text-danger error-message" id="error_up-max_user_used_code"></span>
          </div>

          <div class="form-group">
            <label for="up-expire_date">Expire Date:</label>
            <input type="date" class="form-control" name="up-expire_date" value="{{ now()->format('Y-m-d') }}"
              id="up-expire_date">
            <span class="text-danger error-message" id="error_up-expire_date"></span>
          </div>
        </div>




        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary update_couponcom">Update changes</button>
        </div>
      </div>
    </div>
  </form>
</div>

