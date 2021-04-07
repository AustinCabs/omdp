 <div class="modal fade" id="ann-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Announcement Data</h4>
        </div>
        <div class="modal-body">
          <box class="header">
            <p class="action-name">Create New Announcement</p>
          </box>
          <form action="{{ url('settings/announcement/new') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="form-group">
                <label class="control-label">Description</label>
                <input type="text" name="name" class="form-control name" placeholder="Description">
              </div>
              <div class="form-group">
                <label class="control-label">Date</label>
                <input type="text" name="date" class="form-control date" placeholder="Date">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <script type="text/javascript">
    $(function(){
      $('.date').datepicker({
        autoclose: true
      });
    });
  </script>
