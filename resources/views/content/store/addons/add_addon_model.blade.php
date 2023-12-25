<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addaddModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addAddForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="aaddModalLabel">Add Addon</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>



          <input type="hidden" name="store_id" id="store_id" value="{{ $store->id }}">


          <div class="form-group"></div>
          <label for="name">name</label>
          <input type="text" name="name" class="form-control" id="name">
          <span class="text-danger error-message" id="error_name"></span>
          <br>



          <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" step="0.01" id="price">
            <!-- The "step" attribute is set to "0.01" to allow decimal values -->
            <span class="text-danger error-message" id="error_price"></span>
        </div>


            <div class="form-group">
              <label for="image">Image</label>
              <input type="file" name="image" id="image" accept="image/*">
              <span class="text-danger error-message" id="error_image"></span>
            </div>
<br>
            <!-- Preview the selected image -->
            <div class="form-group">
              {{-- <label for="image-preview">Image Preview</label> --}}
              <img src=""  id="image-preview" style="max-width: 90%; height: 50%; display: block;">
            </div>

            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <script>
              $(document).ready(function () {
        // Update image preview when a file is selected
        $('#image').change(function () {
            var input = this;
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image-preview').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        });
    });
            </script>


            <div class="modal-footer">
              <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary add_add">Save changes</button>
            </div>
          </div>
        </div>
  </form>
</div>










