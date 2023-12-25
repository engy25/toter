<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->

<div class="card invoice-preview-card">

<div class="modal fade" id="addTagModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addTagForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h1 class="modal-title fs-5" id="aaddModalLabel">Add Tag</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>

          <input type="hidden" name="store_id" id="store_id" value="{{ $store->id }}">

          <div class="form-group">
            <label for="thename_en">Name (English)</label>
            <input type="text" name="thename_en" class="form-control" id="thename_en" required>
            <span class="text-danger error-message" id="error_thename_en"></span>
          </div><br>

          <div class="form-group">
            <label for="thename_ar">Name (Arabic)</label>
            <input type="text" name="thename_ar" class="form-control" id="thename_ar" required>
            <span class="text-danger error-message" id="error_thename_ar"></span>
          </div><br>

          <div class="form-group">
            <label for="description_en" class="form-label">Descriprion (English)</label>
            <textarea type="text" class="form-control" id="description_en" name="description_en" style="resize:none;" ></textarea>
          </div>

          <div class="form-group">
            <label for="description_ar" class="form-label">Descriprion (Arabic)</label>
            <textarea type="text" class="form-control" id="description_ar" name="description_ar" style="resize:none;" ></textarea>
          </div>
          <br>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary add_tag">Save changes</button>
        </div>
      </div>
    </div>
  </form>
</div>
