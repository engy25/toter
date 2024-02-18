<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addSizeModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addSizeForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addModalLabel">Add Size</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>


          <input type="hidden" name="item_id"  id="item_id" value="{{ $item->id }}">

          <input type="hidden" name="store_id" id="store_id" value="{{ $item->store_id }}">



          <div class="form-group"></div>
          <label for="name">Name(English)</label>
          <input type="text" name="nameen" class="form-control" id="nameen">
          <span class="text-danger error-message" id="error_nameen"></span>
          <br>

          <div class="form-group"></div>
          <label for="namear">Name(Arabic)</label>
          <input type="text" name="namear" class="form-control" id="namear">
          <span class="text-danger error-message" id="error_namear"></span>
          <br>

        

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary add_size">Save changes</button>
            </div>
          </div>
        </div>
  </form>

</div>










