<form method="post" action="{{ url('/settings/data/create') }}" enctype="multipart/form-data">
  {{ csrf_field() }}

<div class="modal fade" id="new-bill">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><input class="form-control permit_name" name="permit_name" placeholder="Name"></input></h4> <small>Permit Settings</small>
      </div>
      <div class="modal-body">
        <div class="box">
          <div class="box-header">
            <div class="form-group">
              <div class="col-md-6">
                <label class="control-label">Type :</label>
                <select class="form-control permit_type" name="permit_type">
                  <option value="0">Mining</option>
                  <option value="1">Quarry</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="control-label">Document: </label>
                <input class="form-control" name="doc" type="file" accept="application/msword">
              </div>
            </div>
          
            <div class="form-group">
              <div class="col-md-6">
                <label class="control-label">Validity Type :</label>
                <select class="form-control validity-type" name="validity_type">
                  <option value="Years">Year</option>
                  <option value="Days">Day</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="control-label">Validity Unit: </label>
                <input class="form-control" type="number" name="validity_unit">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

</form>