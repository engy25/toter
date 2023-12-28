<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addSideModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addSideForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addModalLabel">Add Side</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>


          <input type="hidden" name="item_id"  id="item_id" value="{{ $item->id }}">

          <input type="hidden" name="store_id" id="store_id" value="{{ $item->store_id }}">



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

          <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" step="0.01" id="price">
            <!-- The "step" attribute is set to "0.01" to allow decimal values -->
            <span class="text-danger error-message" id="error_price"></span>
        </div>


            <div class="form-group">
              <label for="sideImage">Image</label>
              <input type="file" name="sideImage" id="sideImage" accept="image/*">
              <span class="text-danger error-message" id="error_sideImage"></span>
            </div>
<br>
            <!-- Preview the selected image -->
            <div class="form-group">
              {{-- <label for="image-preview">Image Preview</label> --}}
              <img src=""  id="sideImage-preview" style="max-width: 90%; height: 50%; display: block;">
            </div>




            <div class="modal-footer">
              <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary add_side">Save changes</button>
            </div>
          </div>
        </div>
  </form>

</div>










