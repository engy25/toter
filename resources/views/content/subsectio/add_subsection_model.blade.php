<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addSubsectionModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addSubsectionForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addModalLabel">Add Subsection</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>

          <div class="form-group"></div>
          <label for="population">Section </label>
          <select name="section_id" class="form-control" id="section_id">
            <!-- Options will be dynamically populated here using JavaScript -->
          </select>
          <span class="text-danger error-message" id="error_section_id"></span>
          <br>

          <div class="form-group"></div>
          <label for="name">Name(English)</label>
          <input type="text" name="name_en" class="form-control" id="name_en">
          <span class="text-danger error-message" id="error_name_en"></span>
          <br>

          <div class="form-group"></div>
          <label for="name">Name(Arabic)</label>
          <input type="text" name="name_ar" class="form-control" id="name_ar">
          <span class="text-danger error-message" id="error_name_ar"></span>
          <br>


          <label for="description_en">Description (English)</label>
          <textarea name="description_en" class="form-control" id="description_en" style="resize:none;"></textarea>
          <span class="text-danger error-message" id="error_description_en"></span>

          <label for="description_ar">Description (Arabic)</label>
          <textarea name="description_ar" class="form-control" id="description_ar" style="resize:none;"></textarea>
          <span class="text-danger error-message" id="error_description_ar"></span>
          <br>

          <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" accept="image/*">
            <span class="text-danger error-message" id="error_image"></span>
        </div>
        <br>
        <!-- Preview the selected image -->
        <div class="form-group">
            <img src="" id="image-preview" style="max-width: 90%; height: 50%; display: block;">
        </div>


          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary add_subsection">Save changes</button>
          </div>
        </div>
      </div>
  </form>
</div>
