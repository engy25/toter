<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addOptionModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addOptionForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="aaddModalLabel">Add Option</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>


          <input type="hidden" name="item_id"  id="item_id" value="{{ $item->id }}">

          <input type="hidden" name="store_id" id="store_id" value="{{ $item->store_id }}">



          <div class="form-group"></div>
          <label for="optionname_en">Name(English)</label>
          <input type="text" name="optionname_en" class="form-control" id="optionname_en">
          <span class="text-danger error-message" id="error_optionname_en"></span>
          <br>

          <div class="form-group"></div>
          <label for="optionname_ar">Name(Arabic)</label>
          <input type="text" name="optionname_ar" class="form-control" id="optionname_ar">
          <span class="text-danger error-message" id="error_optionname_ar"></span>
          <br>

       


            <div class="form-group">
              <label for="optionimage">Image</label>
              <input type="file" name="optionimage" id="optionimage" accept="image/*">
              <span class="text-danger error-message" id="error_optionimage"></span>
            </div>
<br>
            <!-- Preview the selected image -->
            <div class="form-group">
              {{-- <label for="image-preview">Image Preview</label> --}}
              <img src=""  id="optionimage-preview" style="max-width: 90%; height: 50%; display: block;">
            </div>

            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <script>
              $(document).ready(function () {
        // Update image preview when a file is selected
        $('#optionimage').change(function () {
            var input = this;
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#optionimage-preview').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        });
    });
            </script>


            <div class="modal-footer">
              <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary add_option">Save changes</button>
            </div>
          </div>
        </div>
  </form>
</div>










