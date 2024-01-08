<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Modal -->
<div class="modal fade" id="updateRoleModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <form action="" method="POST" id="updateRoleForm">
    @csrf
    <input type="hidden" id="up_id">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateModalLabel">Update Role</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>


          <div class="form-group"></div>
          <label for="guard">guard </label>
          <select name="guard" class="form-control" id="guard">
            <option value="web">Web</option>
            <option value="api">Mobile</option>
          </select>
          <span class="text-danger error-message" id="error_guard"></span>
          <br>

          <div class="form-group"></div>
          <label for="up_name">Name </label>
          <input type="text" name="up_name" class="form-control" id="up_name">
        </div>
        <span class="text-danger error-message" id="error_up_name"></span>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary update_role">Update changes</button>
        </div>
      </div>
    </div>
  </form>
</div>
