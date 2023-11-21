<?php
$continents=['Asia', 'North America', 'South America', 'Antarctica', 'Europe', 'Australia', 'Africa'];
?>

<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <form action="" method="POST" id="update_country_form">
    @csrf
    <input type="hidden" id="up_id">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateModalLabel">{{ trans('words.update_Country') }}</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>



          <div class="form-group"></div>
          <label for="up_currency_id">Currency </label>
          <select name="up_continent" class="form-control" id="up_continent">
            <option value="">Select Continent</option>
            @foreach($continents as $continent)
            <option value="{{ $continent }}">{{ $continent }}</option>
            @endforeach
          </select>
          <span class="text-danger error-message" id="error_up_continent"></span>
          <br>



          <div class="form-group"></div>
          <label class="required" for="up_continent">Continent </label>
          <select name="up_currency_id" class="form-control" id="up_currency_id">
            <!-- Options will be dynamically populated here using JavaScript -->
          </select>
          <span class="text-danger error-message" id="error_up_currency_id"></span>
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


        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_region_en">Region (English) </label>

          <input type="text" name="up_region_en" class="form-control" id="up_region_en">
        </div>
        <span class="text-danger error-message" id="error_up_region_en"></span>



        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_region_ar">Region (Arabic) </label>
          <input type="text" name="up_region_ar" class="form-control" id="up_region_ar">
        </div>
        <span class="text-danger error-message" id="error_up_region_ar"></span>


        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_code">Code </label>
          <input type="number" name="up_code" class="form-control" id="up_code">
        </div>
        <span class="text-danger error-message" id="error_up_code"></span>


        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_code2">Code 2</label>
          <input type="text" name="up_code2" class="form-control" id="up_code2">
        </div>
        <span class="text-danger error-message" id="error_up_code2"></span>

        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_localName_en">localName (English) </label>
          <input type="text" name="up_localName_en" class="form-control" id="up_localName_en">
        </div>
        <span class="text-danger error-message" id="error_up_localName_en"></span>


        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_localName_ar">>localName (Arabic) </label>
          <input type="number" name="up_localName_ar" class="form-control" id="up_localName_ar">
        </div>
        <span class="text-danger error-message" id="error_up_localName_ar"></span>


        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_governmentForm_en">governmentForm(English) </label>
          <input type="text" name="up_governmentForm_en" class="form-control" id="up_governmentForm_en">
        </div>
        <span class="text-danger error-message" id="error_up_governmentForm_en"></span>


        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_governmentForm_ar">governmentForm(Arabic) </label>
          <input type="number" name="up_governmentForm_ar" class="form-control" id="up_governmentForm_ar">
        </div>
        <span class="text-danger error-message" id="error_up_governmentForm_ar"></span>

        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_HeadOfState">HeadOfState</label>
          <input type="text" name="up_HeadOfState" class="form-control" id="up_HeadOfState">
        </div>
        <span class="text-danger error-message" id="error_up_HeadOfState"></span>


        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_capital">Capital </label>
          <input type="number" name="up_capital" class="form-control" id="up_capital">
        </div>
        <span class="text-danger error-message" id="error_up_capital"></span>

        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_IndepYear">IndepYear</label>
          <input type="number" name="up_IndepYear" class="form-control" id="up_IndepYear">
        </div>
        <span class="text-danger error-message" id="error_up_IndepYear"></span>


        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_population">Population</label>
          <input type="number" name="up_population" class="form-control" id="up_population">
        </div>
        <span class="text-danger error-message" id="error_up_population"></span>


        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_surfaceArea">surfaceArea</label>
          <input type="number" name="up_surfaceArea" class="form-control" id="up_surfaceArea">
        </div>
        <span class="text-danger error-message" id="error_up_surfaceArea"></span>


        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_lifeExpectancy">lifeExpectancy</label>
          <input type="number" name="up_lifeExpectancy" class="form-control" id="up_lifeExpectancy">
        </div>
        <span class="text-danger error-message" id="error_up_lifeExpectancy"></span>

        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_GNP">GNP</label>
          <input type="number" name="up_GNP" class="form-control" id="up_GNP">
        </div>
        <span class="text-danger error-message" id="error_up_GNP"></span>


        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_GNPOld">GNPOld</label>
          <input type="number" name="up_GNPOld" class="form-control" id="up_GNPOld">
        </div>
        <span class="text-danger error-message" id="error_up_GNPOld"></span>





















        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary update_country">Update changes</button>
        </div>
      </div>
    </div>
  </form>
</div>
