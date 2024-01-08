<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="addRoleForm">
    @csrf
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addModalLabel">Add Role</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>

          <div class="form-group"></div>
          <label for="population">Guard </label>
          <select name="guard" class="form-control" id="guard">
           <option value="web">Web</option>
           <option value="api">Mobile</option>
          </select>
          <span class="text-danger error-message" id="error_guard"></span>
          <br>



          <div class="form-group"></div>
          <label for="name">Name</label>
          <input type="text" name="name" class="form-control" id="name">
          <span class="text-danger error-message" id="error_name"></span>
          <br>



          <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary add_role">Save changes</button>
          </div>
        </div>
      </div>
  </form>
</div>
