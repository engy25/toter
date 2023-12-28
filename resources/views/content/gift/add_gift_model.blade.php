<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addGiftModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addGiftForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addModalLabel">Add Gift</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>


          <input type="hidden" name="item_id"  id="item_id" value="{{ $item->id }}">

          <input type="hidden" name="store_id" id="store_id" value="{{ $item->store_id }}">



          <div class="form-group"></div>
          <label for="name">Name</label>
          <input type="text" name="thename" class="form-control" id="thename">
          <span class="text-danger error-message" id="error_thename"></span>
          <br>




            <div class="form-group">
              <label for="sideImage">Image</label>
              <input type="file" name="giftImage" id="giftImage" accept="image/*">
              <span class="text-danger error-message" id="error_giftImage"></span>
            </div>
<br>
            <!-- Preview the selected image -->
            <div class="form-group">
              {{-- <label for="image-preview">Image Preview</label> --}}
              <img src=""  id="giftImage-preview" style="max-width: 90%; height: 50%; display: block;">
            </div>




            <div class="modal-footer">
              <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary add_gift">Save changes</button>
            </div>
          </div>
        </div>
  </form>

</div>










