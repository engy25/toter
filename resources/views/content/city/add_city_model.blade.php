<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addCityForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addModalLabel">Add City</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>

          <div class="form-group"></div>
          <label for="population">Country </label>
          <select name="country_id" class="form-control" id ="country_id" >
             <!-- Options will be dynamically populated here using JavaScript -->
          </select>
           <span class="text-danger error-message" id="error_country_id"></span>
          <br>
          


          <div class="form-group"></div>
          <label for="name">CountryCode</label>
          <input type="text" name="CountryCode" class="form-control" id="CountryCode">
          <span class="text-danger error-message" id="error_CountryCode"></span>
          <br>



          <div class="form-group"></div>
          <label for="name">District(Arabic)</label>
          <input type="text" name="district_ar" class="form-control" id="district_ar">
          <span class="text-danger error-message" id="error_district_ar"></span>
           <br>
           <div class="form-group"></div>
           <label for="name">District(English)</label>
           <input type="text" name="district_en" class="form-control" id="district_en">
           <span class="text-danger error-message" id="error_district_en"></span> <br>
          <div class="form-group"></div>
          <label for="name">Name(Arabic)</label>
          <input type="text" name="name_ar" class="form-control" id="name_ar">
          <span class="text-danger error-message" id="error_name_ar"></span>
           <br>
          <div class="form-group"></div>
          <label for="name">Name(English)</label>
          <input type="text" name="name_en" class="form-control" id="name_en">
          <span class="text-danger error-message" id="error_name_en"></span>
          <br>

            <div class="form-group"></div>
            <label for="population">Population </label>
            <input type="number" name="population" class="form-control" id="population" >
            <span class="text-danger error-message" id="error_population"></span>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary add_city">Save changes</button>
          </div>
        </div>
      </div>
  </form>
</div>
