<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Modal -->
<div class="modal fade" id="updateDistrictModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <form action="" method="POST" id="updateDistrictForm">
    @csrf
    <input type="hidden" id="up_id">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateModalLabel">Update Company  District</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3"></div>


          <div class="mb-3">
            <label for="delivery_charge">Delivery Charge</label>
            <input type="number" name="updelivery_charge" class="form-control" step="0.01" id="updelivery_charge">
            <span class="text-danger error-message" id="error_updelivery_charge"></span>
          </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary update_company_district">Update changes</button>
        </div>
      </div>
    </div>
  </form>
</div>
