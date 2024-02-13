<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addCouponCompanyModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addCouponCompanyForm">
    @csrf
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
          <input type="text" name="Thecode" class="form-control" id="Thecode">
          <span class="text-danger error-message" id="error_Thecode"></span>
          <br>


          <div>
            <label for="priceRadio">Price</label>
            <input type="radio" name="type" id="priceRadio" value="price">
          </div>

          <div class="form-group">
            <label for="discountRadio">Discount Percentage</label>
            <input type="radio" name="type" id="discountRadio" value="discount">
          </div>

          <div id="discountInput" style="display: none;">
            <label for="discount">Discount Percentage</label>
            <input type="number" class="form-control"name="discount" id="discount">
            <span class="text-danger error-message" id="error_discount"></span>
          </div>

          <div id="priceInput" style="display: none;">
            <label for="Price">Price</label>

            <input type="number" class="form-control"name="Price" id="Price">
            <span class="text-danger error-message" id="error_price"></span>


          </div>


          <div class="form-group">
            <label for="Max_user_used_code">Max User Used Code</label>
            <input type="number" class="form-control" name="Max_user_used_code" id="Max_user_used_code">
            <span class="text-danger error-message" id="error_Max_user_used_code"></span>
          </div>
          <br>


          <div class="form-group">
            <label for="Expire_date">Expire Date</label>
            <input type="date" class="form-control" name="Expire_date" value="{{ now()->format('Y-m-d') }}"
              id="Expire_date">
            <span class="text-danger error-message" id="error_Expire_date"></span>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary add_couponcompany">Save changes</button>
          </div>
        </div>
      </div>
  </form>
</div>



<script>
  document.getElementById("Discount_percentage").onkeyup=function(){
      var input=parseInt(this.value);
      if(input<0 || input>100)
      alert("Value should be between 0 - 100");
      return;
  }
</script>


