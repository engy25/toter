<?php
$continents=['Asia', 'North America', 'South America', 'Antarctica', 'Europe', 'Australia', 'Africa'];
?>

<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addCountryForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addModalLabel">{{ trans('words.Add_Country') }}</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>



          <div class="form-group"></div>
          <label class="required" for="currency">Currency </label>
          <select name="currency_id" class="form-control" id="currency_id">
            <!-- Options will be dynamically populated here using JavaScript -->
          </select><br>


          <div class="form-group">
            <label class="required" for="continent">Continent</label>
            <select name="continent" class="form-control" id="continent">
                <option value="">Select Continent</option>
                @foreach($continents as $continent)
                    <option value="{{ $continent }}">{{ $continent }}</option>
                @endforeach
            </select>
            <span class="text-danger error-message" id="error_continent"></span>
        </div><br>



          <div class="form-group"></div>
          <label class="required" for="name">Code</label>
          <input type="text" name="code" class="form-control" id="code">
          <br>

          <div class="form-group"></div>
          <label for="name">Code2</label>
          <input type="text" name="code2" class="form-control" id="code2">
          <br>

          <div class="form-group"></div>
          <label class="required" for="name">Name(English)</label>
          <input type="text" name="name_en" class="form-control" id="name_en">
          <br>

          <div class="form-group"></div>
          <label class="required" for="name">Name(Arabic)</label>
          <input type="text" name="name_ar" class="form-control" id="name_ar">
          <br>



          <div class="form-group"></div>
          <label class="required" for="name">Region(English)</label>
          <input type="text" name="region_en" class="form-control" id="region_en"> <br>

          <div class="form-group"></div>
          <label class="required" for="name">Region(Arabic)</label>
          <input type="text" name="region_ar" class="form-control" id="region_ar"> <br>



          <div class="form-group">
            <label class="required" for="localName_en">localName(English)</label>
            <input type="text" name="localName_en" class="form-control" id="localName_en">
          </div><br>

          <div class="form-group">
            <label class="required" for="localName_ar">localName(Arabic)</label>
            <input type="text" name="localName_ar" class="form-control" id="localName_ar">
          </div><br>


          <div class="form-group"></div>
          <label  class="required" for="name">governmentForm(English) </label>
          <input type="text" name="governmentForm_en" class="form-control" id="governmentForm_en"> <br>

          <div class="form-group"></div>
          <label class="required" for="name">governmentForm(Arabic)</label>
          <input type="text" name="governmentForm_ar" class="form-control" id="governmentForm_ar"> <br>



          <div class="form-group"></div>
          <label   for="name">HeadOfState</label>
          <input type="text" name="HeadOfState" class="form-control" id="HeadOfState"> <br>

          <div class="form-group"></div>
          <label for="name">Capital</label>
          <input type="text" name="capital" class="form-control" id="capital"> <br>

          <div class="form-group"></div>
          <label for="name">IndepYear</label>
          <input type="number" name="IndepYear" class="form-control" id="IndepYear"> <br>

          <div class="form-group"></div>
          <label for="population">Population </label>
          <input type="number" name="population" class="form-control" id="population" >
          <span class="text-danger error-message" id="error_population"></span>



          <div class="form-group"></div>
          <label for="name">surfaceArea</label>
          <input type="number" name="surfaceArea" class="form-control" id="surfaceArea"> <br>

          <div class="form-group"></div>
          <label for="name">lifeExpectancy</label>
          <input type="number" name="lifeExpectancy" class="form-control" id="lifeExpectancy"> <br>

          <div class="form-group"></div>
          <label for="name">GNP</label>
          <input type="number" name="GNP" class="form-control" id="GNP"> <br>

          <div class="form-group"></div>
          <label for="name">GNPOld</label>
          <input type="number" name="GNPOld" class="form-control" id="GNPOld"> <br>




          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary add_country">Save changes</button>
          </div>
        </div>
      </div>
  </form>
</div>
