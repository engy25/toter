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
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>
          <div class="form-group"></div>
          <label for="name_en">Name (English)</label>
          <input type="text" name="up_name_en" class="form-control" id="up_name_en" value="{{ $city->name_en }}">
        </div>

        <div class="modal-body">
          <div class="form-group"></div>
          <label for="name_ar">Name (Arabic) </label>
          <input type="text" name="up_name_ar" class="form-control" id="up_name_ar" value="{{ $city->name_ar }}">
        </div>

        <div class="modal-body">
          <div class="form-group"></div>
          <label for="district_en">District (English) </label>

          <input type="text" name="up_district_en" class="form-control" id="up_district_en" value="{{ $city->district_en }}">
        </div>

        <div class="modal-body">
          <div class="form-group"></div>
          <label for="district_ar">District (Arabic) </label>
          <input type="text" name="up_district_ar" class="form-control" id="up_district_ar" value="{{ $city->district_ar }}">
        </div>


        <div class="modal-body">
          <div class="form-group"></div>
          <label for="population">Population </label>
          <input type="number" name="up_population" class="form-control" id="up_population" value="{{ $city->population }}">
        </div>


        <div class="modal-body">
          <div class="form-group"></div>
          <label for="CountryCode">CountryCode </label>
          <input type="text" name="up_CountryCode" class="form-control" id="up_CountryCode"  value="{{ $city->CountryCode }}">>
        </div>




        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary update_city">Update changes</button>
        </div>
      </div>
    </div>
  </form>
</div>
