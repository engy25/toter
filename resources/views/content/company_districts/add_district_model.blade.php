<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addDistrictCompanyModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addDistrictCompanyForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addModalLabel">Add DistrictCompany</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>

          <?php
          $countryiraq=App\Models\CountryTranslation::where("name","iraq")->first();
          $cities=App\Models\City::where("country_id",$countryiraq->country_id)->get();
          ?>

          <div class="form-group"></div>
          <label for="population">City </label>

          <select name="city_id" class="form-control" id="city_id">
            @foreach($cities as $city)
            <option value={{ $city->id }}>{{ $city->name }}</option>
            @endforeach
          </select>

          <span class="text-danger error-message" id="error_city_id"></span>
          <br>


          <select name="from_id" class="form-control" id="from_id">

          </select>
          <span class="text-danger error-message" id="error_from_id"></span>

          <div class="form-group"></div>
          <label for="population">City </label>

          <select name="to_city_id" class="form-control" id="to_city_id">
            @foreach($cities as $city)
            <option value={{ $city->id }}>{{ $city->name }}</option>
            @endforeach
          </select>

          <span class="text-danger error-message" id="error_to_city_id"></span>
          <br>

          <select name="to_id" class="form-control" id="to_id">

          </select>
          <span class="text-danger error-message" id="error_to_id"></span>


          <!-- Price -->
          <div class="mb-3">
            <label for="delivery_charge">Delivery Charge</label>
            <input type="number" name="delivery_charge" class="form-control" step="0.01" id="delivery_charge">
            <span class="text-danger error-message" id="error_delivery_charge"></span>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary add_districtCompany">Save changes</button>
          </div>
        </div>
      </div>
  </form>
</div>
