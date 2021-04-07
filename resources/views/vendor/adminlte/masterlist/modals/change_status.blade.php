 <div class="modal fade" id="changeStatus">
    <div class="modal-dialog">
      <form action="{{ url('/masterlist/changeStatus').'/'.$masterlist->id }}" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Application Status</h4>
          </div>
          <div class="modal-body">
                <div class="form-group">
                  <label class="control-label">Status : </label>
                  <select class="form-control" name="status">
                    <option value="0" @if ($masterlist->status == 0) {{ 'selected' }}@endif>Pending</option>
                    <option value="1" @if ($masterlist->status == 1) {{ 'selected' }}@endif>Approved</option>
                    <option value="2" @if ($masterlist->status == 2) {{ 'selected' }}@endif>Declined</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label">Remarks : </label>
                  <textarea class="form-control" name="remarks">{{ strip_tags($masterlist->remarks) }}</textarea>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button id="pay-fee" type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </form>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
