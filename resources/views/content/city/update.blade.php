<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <form action="" method="POST" id="updateCityForm">
    @csrf
    <input type="hidden" id="up_id">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateModalLabel">Update City</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>


          <div class="form-group"></div>
          <label for="up_country_id">Country </label>
          <select name="up_country_id" class="form-control" id ="up_country_id" >
             <!-- Options will be dynamically populated here using JavaScript -->
          </select>
           <span class="text-danger error-message" id="error_up_country_id"></span>
          <br>



          <div class="form-group"></div>
          <label for="name_en">Name (English)</label>
          <input type="text" name="up_name_en" class="form-control" id="up_name_en">
        </div>
        <span class="text-danger error-message" id="error_name_en"></span>



        <div class="modal-body">
          <div class="form-group"></div>
          <label for="name_ar">Name (Arabic) </label>
          <input type="text" name="up_name_ar" class="form-control" id="up_name_ar">
        </div>
        <span class="text-danger error-message" id="error_name_ar"></span>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary update_city">Update changes</button>
        </div>
      </div>
    </div>
  </form>
</div>
