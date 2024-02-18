<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addIngredientForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="aaddModalLabel">Add Ingredient</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>


          <input type="hidden" name="item_id"  id="item_id" value="{{ $item->id }}">

          <input type="hidden" name="store_id" id="store_id" value="{{ $item->store_id }}">

          <div class="form-group">
            <label for="add">Add or Remove?</label>
            <select name="add" id="add" class="form-control">
                <option value="1" {{ $add == 1 ? 'selected' : '' }}>Add</option>
                <option value="0" {{ $add == 0 ? 'selected' : '' }}>Remove</option>
            </select>
        </div>

          <div class="form-group"></div>
          <label for="the_name_en">Name(English)</label>
          <input type="text" name="the_name_en" class="form-control" id="the_name_en">
          <span class="text-danger error-message" id="error_the_name_en"></span>
          <br>

          <div class="form-group"></div>
          <label for="the_name_ar">Name(Arabic)</label>
          <input type="text" name="the_name_ar" class="form-control" id="the_name_ar">
          <span class="text-danger error-message" id="error_the_name_ar"></span>
          <br>



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
              <button type="button" class="btn btn-primary add_ingredient">Save changes</button>
            </div>
          </div>
        </div>
  </form>
</div>










