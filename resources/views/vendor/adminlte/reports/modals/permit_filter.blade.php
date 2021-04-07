 <div class="modal fade" id="permiteeFilters">
    <div class="modal-dialog">
      <form action="{{ url('reports') }}" method="GET">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Filter Data </h4><small>Permitee List</small>
          </div>
          <div class="modal-body">
            <div class="box">
              <input type="hidden" name="query_type" value="query">
                <div class="form-group">
                  <label class="control-label">Permit Type : </label>
                  <select class="form-control" name="permitType">
                    @foreach($permitTypes as $row)
                      <option value="{{ $row->id }}">{{ $row->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label">Date : </label>
                  <input class="form-control" name="date" id="date" placeholder="Select Month">
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
          </div>
        </div>
      </form>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <script type="text/javascript">
    $(function(){
      $('#date').datepicker( {
            format: "yyyy-mm",
            viewMode: "months", 
            minViewMode: "months"
      });
    })
  </script>
