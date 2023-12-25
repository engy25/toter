<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->

<div class="card invoice-preview-card">

<div class="modal fade" id="addDrinkModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addDrinkForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="aaddModalLabel">Add Drink</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>

          <input type="hidden" name="store_id" id="store_id" value="{{ $store->id }}">

          <div class="form-group">
            <label for="name_en">Name (English)</label>
            <input type="text" name="name_en" class="form-control" id="name_en" required>
            <span class="text-danger error-message" id="error_name_en"></span>
          </div><br>

          <div class="form-group">
            <label for="name_ar">Name (Arabic)</label>
            <input type="text" name="name_ar" class="form-control" id="name_ar" required>
            <span class="text-danger error-message" id="error_name_ar"></span>
          </div><br>

          <div class="form-group">
            <label for="prices">Price</label>
            <input type="number" name="prices" class="form-control" step="0.01" id="prices" required>
            <span class="text-danger error-message" id="error_prices"></span>
          </div><br>

          <div class="form-group">
            <label for="images">Image</label>
            <input type="file" name="images" id="images" accept="image/*" required>
            <span class="text-danger error-message" id="error_images"></span>
          </div>
          <br><br>
          <!-- Preview the selected image -->
          <div class="form-group">
            <img src="" id="image-previews" style="max-width: 90%; height: 50%; display: block;">
          </div>

          <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
          <script>
            $(document).ready(function () {
              // Update image preview when a file is selected
              $('#images').change(function () {
                var input = this;
                var reader = new FileReader();

                reader.onload = function (e) {
                  $('#image-previews').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
              });
            });
          </script>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary add_drink">Save changes</button>
        </div>
      </div>
    </div>
  </form>
</div>
