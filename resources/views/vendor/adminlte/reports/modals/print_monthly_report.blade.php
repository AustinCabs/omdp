 <div class="modal fade" id="printMonthlyReport">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Print Report </h4>
          </div>
          <div class="modal-body">
            <div class="box">
                <div class="form-group">
                  <label class="control-label">Type :</label>
                  <select class="form-control type">
                    <option value="month">Monthly</option>
                    <option value="year">Annual</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label">Date : </label>
                  <input class="form-control" name="date" id="pickDate" placeholder="Select Month">
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <a class="btn btn-primary" id="print-report"><i class="fa fa-print"></i> Print</a>
          </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <script type="text/javascript">
    $(function(){
      $('#pickDate').datepicker( {
            format: "yyyy-mm",
            viewMode: "months", 
            minViewMode: "months"
      });
      $('#pickDate').datepicker('setDate', "{{date('Y-m')}}");

      $('#print-report').on('click', function(e){
        e.preventDefault();
        var type = $('.type').val();
        var date = $('#pickDate').val();
        if(date){
          window.open("{{ url('exports').'?date=' }}"+date+"&type="+type)
        }
      })
    })
  </script>
