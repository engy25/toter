<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Modal -->
<div class="modal fade" id="updateIngredientModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <form action="" method="POST" id="updateIngredientForm" enctype="multipart/form-data">>
    @csrf
    <input type="hidden" id="up_id">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateModalLabel">Update Ingredient</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>

          <div class="modal-body">
            <div class="form-group">
              <label for="up_add">Add or Remove?</label>
              <select name="up_add" id="up_add" class="form-control">
                <option value="1" {{ $add==1 ? 'selected' : '' }}>Add</option>
                <option value="0" {{ $add==0 ? 'selected' : '' }}>Remove</option>
              </select>
            </div>

            <br>



            <div class="form-group">
              <label for="upnameen">Name (English)</label>
              <input type="text" name="upnameen" class="form-control" id="upnameen">
              <span class="text-danger error-message" id="error_upnameen"></span>
            </div>
            <br>

            <div class="form-group">
              <label for="upnamear">Name (Arabic) </label>
              <input type="text" name="upnamear" class="form-control" id="upnamear">
              <span class="text-danger error-message" id="error_upnamear"></span>
            </div>
            <br>

            <div class="form-group">
              <label for="upprice">Price</label>
              <input type="number" name="upprice" class="form-control" step="0.01" id="upprice">
              <!-- The "step" attribute is set to "0.01" to allow decimal values -->
              <span class="text-danger error-message" id="error_upprice"></span>
            </div>




            <div class="form-group">
              <label for="up_image">Image</label>
              <input type="file" name="upimage" id="upimage" accept="image/*">
              <span class="text-danger error-message" id="error_upimage"></span>
            </div>
            <br><br>

            <!-- Preview the selected image -->
            <div class="form-group">
              {{-- <label for="image-preview">Image Preview</label> --}}
              <img src="" id="image-preview" style="max-width: 90%; height: 50%; display: block;">
            </div>
          </div>

          <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
          <script>
            $(document).ready(function () {
    // Update image preview when a file is selected
    $('#up_image').change(function () {
        var input = this;
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#image-preview').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    });

    // Update image preview when modal is opened
    $('#updateModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var imageSrc = button.data('image'); // Get image URL from data attribute

        // Set the src attribute of the image preview
        $('#image-preview').attr('src', imageSrc);
    });
});


          </script>


          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary update_ingredient">Update changes</button>
          </div>
        </div>
      </div>
  </form>
</div>
