<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <form action="" method="POST" id="updateWeekhourForm">

    @csrf
    <input type="hidden" id="up_id">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateModalLabel">Update WeekHour</h1>
          <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="errMsgContainer mb-3">
          </div>

          <label for="day{{ $weekhour->day_id }}" class="form-label">Day </label>
          <select class="form-control" id="day{{ $weekhour->day_id }}" name="weekhours" required>
            <option>Select Day</option>
            @foreach ($days as $day)
            <div>{{ $day_id }}</div>

            <option value="{{ $day->id }}" {{ $day->id == $day_id ? 'selected' : '' }}>
              {{ $day->name }}
            </option>
            @endforeach
          </select>
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary update_weekhour">Update changes</button>
      </div>
    </div>
</div>
</form>
</div>
