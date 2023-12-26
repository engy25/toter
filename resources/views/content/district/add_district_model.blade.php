<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addDistrictModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addDistrictForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addModalLabel">Add District</h1>
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


          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary add_district">Save changes</button>
          </div>
        </div>
      </div>
  </form>
</div>
