<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Modal -->
<div class="modal fade" id="updateTagModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <form action="" method="POST" id="updateTagForm">
    @csrf
    <input type="hidden" id="up_id">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateModalLabel">Update Tag</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>



          <div class="form-group"></div>
          <label for="up_names_en">Name (English)</label>
          <input type="text" name="up_names_en" class="form-control" id="up_names_en">
        </div>
        <span class="text-danger error-message" id="error_up_names_en"></span>



        <div class="modal-body">
          <div class="form-group"></div>
          <label for="up_names_ar">Name (Arabic) </label>
          <input type="text" name="up_names_ar" class="form-control" id="up_names_ar">
        </div>
        <span class="text-danger error-message" id="error_up_names_ar"></span>



        <div class="modal-body">
          <label for="description_en">Description (English)</label>
          <textarea name="up_descriptions_en" class="form-control" id="up_descriptions_en"
            style="resize:none;"></textarea>
          <span class="text-danger error-message" id="error_up_descriptions_en"></span>
        </div>


        <div class="modal-body">
          <label for="up_descriptions_ar">Description (Arabic)</label>
          <textarea name="up_descriptions_ar" class="form-control" id="up_descriptions_ar"
            style="resize:none;"></textarea>
          <span class="text-danger error-message" id="error_up_descriptions_ar"></span>
        </div>
        <br>




        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary update_tag">Update changes</button>
        </div>
      </div>
    </div>
  </form>
</div>
