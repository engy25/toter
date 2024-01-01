<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Update Subsection Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <form action="" method="POST" id="updateSubsectionForm" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="up_id">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateModalLabel">Update Subsection</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3"></div>

          <div class="form-group">
            <label for="up_section_id">Section </label>
            <select name="up_section_id" class="form-control" id="up_section_id">
              <!-- Options will be dynamically populated here using JavaScript -->
            </select>
            <span class="text-danger error-message" id="error_up_section_id"></span>
          </div>
          <br>

          <div class="form-group">
            <label for="up_name_en">Name (English)</label>
            <input type="text" name="up_name_en" class="form-control" id="up_name_en">
            <span class="text-danger error-message" id="error_up_name_en"></span>
          </div>
          <br>

          <div class="form-group">
            <label for="up_name_ar">Name (Arabic) </label>
            <input type="text" name="up_name_ar" class="form-control" id="up_name_ar">
            <span class="text-danger error-message" id="error_up_name_ar"></span>
          </div>
          <br>

          <div class="form-group">
            <label for="up_description_en">Description (English)</label>
            <textarea name="up_description_en" class="form-control" id="up_description_en" style="resize:none;"></textarea>
            <span class="text-danger error-message" id="error_up_description_en"></span>
          </div>

          <div class="form-group">
            <label for="up_description_ar">Description (Arabic)</label>
            <textarea name="up_description_ar" class="form-control" id="up_description_ar" style="resize:none;"></textarea>
            <span class="text-danger error-message" id="error_up_description_ar"></span>
          </div>
          <br>

          <div class="form-group">
            <label for="up_image">Image</label>
            <input type="file" name="up_image" id="up_image" accept="image/*">
            <span class="text-danger error-message" id="error_up_image"></span>
          </div>
          <br>

          <!-- Preview the selected image -->
          <div class="form-group">
            <img src="" id="image-preview" style="max-width: 90%; height: 50%; display: block;">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary update_subsection">Update changes</button>
        </div>
      </div>
    </div>
  </form>
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
