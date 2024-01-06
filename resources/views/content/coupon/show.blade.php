
<!-- Modal -->

  <div class="modal fade" id="showCouponModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addModalLabel">Add Coupon</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>




          <div class="form-group"></div>
          <label for="name">Code</label>
          <input type="text" name="code" class="form-control" id="code">
          <span class="text-danger error-message" id="error_code"></span>
          <br>

          <div class="form-group">
            <label for="discount_percentage">Discount Percentage</label>
            <input type="number" class="form-control" name="discount_percentage" id="discount_percentage" step="0.01">
            <span class="text-danger error-message" id="error_discount_percentage"></span>
          </div>
          <br>
          <div class="form-group">
            <label for="max_user_used_code">Max User Used Code</label>
            <input type="number" class="form-control" name="max_user_used_code" id="max_user_used_code">
            <span class="text-danger error-message" id="error_max_user_used_code"></span>
          </div>
          <br>


          <div class="form-group">
            <label for="expire_date">Expire Date</label>
            <input type="date" class="form-control" name="expire_date" value="{{ now()->format('Y-m-d') }}" id="expire_date">
            <span class="text-danger error-message" id="error_expire_date"></span>
          </div>



</div>
