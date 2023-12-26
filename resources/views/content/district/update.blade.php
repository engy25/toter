<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Modal -->
<div class="modal fade" id="updateDistrictModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <form action="" method="POST" id="updateDistrictForm">
    @csrf
    <input type="hidden" id="up_id">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateModalLabel">Update District</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3"></div>


          <div class="form-group">
            <label for="up_city_id">City </label>
            <select name="up_city_id" class="form-control" id="up_city_id">
              <!-- Options will be dynamically populated here using JavaScript -->
            </select>
            <span class="text-danger error-message" id="error_up_city_id"></span>
          </div>



          <br>
          <div class="form-group">
            <label for="up_name_en">Name (English)</label>
            <input type="text" name="up_name_en" class="form-control" id="up_name_en">
            <span class="text-danger error-message" id="error_up_name_en"></span>
          </div>
          <br>

          <div class="form-group">
            <label for="up_name_ar">Name (Arabic)</label>
            <input type="text" name="up_name_ar" class="form-control" id="up_name_ar">
            <span class="text-danger error-message" id="error_up_name_ar"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary update_district">Update changes</button>
        </div>
      </div>
    </div>
  </form>
</div>
