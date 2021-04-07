  <div class="modal fade" id="reportModalShow">
    <div class="modal-dialog modal-lg">
      <form id="#ReportForm" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Sales and Production Report</h4>
          </div>
          
            <div class="modal-body">
              
                <input type="hidden" class="report_id">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Report Period</label>
                      <input class="form-control date" name="date" id="date">
                    </div>
                  </div>
                    
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">No. of days in Operation</label>
                      <input class="form-control days_of_operation" type="number" name="days_of_operation">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Prepared By:</label>
                      <input class="form-control prepared_by" type="text" name="prepared_by">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="box">
                    <div class="box-header">
                      <p class="box-title">Production and Sales/Marketing Data</p>
                      <a class="btn btn-primary pull-right add-production-row"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="box-body">
                      <table class="table table-bordered" id="production">
                      <thead>
                        <tr>
                          <th colspan="1">Materials</th>
                          <th colspan="2" align="center">Production</th>
                          <th colspan="2" align="center">Sales</th>
                          <th colspan="2" align="center">Monthly Inventory</th>
                          <th align="center">Estimated Extraction Fee Payable</th>
                          <th align="center">Estimated Excise Tax Payable</th>
                          <th align="center">Buyer/Address</th>
                          <th></th>
                        </tr>
                        <tr>
                          <th></th>
                          <td>Quantity (cu. m.)</td>
                          <td>Value (P)</td>
                          <td>Quantity (cu. m.)</td>
                          <td>Value (P)</td>
                          <td>Quantity (cu. m.)</td>
                          <td>Value (P)</td>                  
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                      </table>
                    </div>
                  </div>
                  
                  
                </div>

                <div class="row">
                  <div class="box">
                    <div class="box-header">
                      <p class="box-title">Employment Data</p>
                    </div>
                    <div class="box-body">
                      <table class="table table-bordered" id="employment">
                      <thead>
                        <tr>
                          <th colspan="2" align="center">Office</th>
                          <th colspan="2" align="center">Site</th>
                          <th></th>
                        </tr>
                        <tr>
                          <th>Male</th>
                          <td>Female</td>
                          <td>Male</td>
                          <td>Female</td>                 
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><input class="form-control o_male" name="o_male" type="number"></td>
                          <td><input class="form-control o_female" name="o_female" type="number"></td>
                          <td><input class="form-control s_male" name="s_male" type="number"></td>
                          <td><input class="form-control s_female" name="s_female" type="number"></td>
                        </tr>
                      </tbody>
                      </table>
                    </div>
                  </div> 
                </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary update-report">Save changes</button>
            </div>
          
        </div>
      </form>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->


  </div>
  <script type="text/javascript">
    $(function(){

      $('.date').datepicker( {
            format: "yyyy-mm",
            viewMode: "months", 
            minViewMode: "months"
      });

      $(document).on('click', '.save-prod', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var row = $(this).parent().parent();

        var data = {
          'materials': row.closest('tr').find('.materials').val(),
          'p_quantity' :row.closest('tr').find('.p_quantity').val(),
          'p_value': row.closest('tr').find('.p_value').val(),
          's_quantity' : row.closest('tr').find('.s_quantity').val(),
          's_value' : row.closest('tr').find('.s_value').val(),
          'mi_quantity' : row.closest('tr').find('.mi_quantity').val(),
          'mi_value' : row.closest('tr').find('.mi_value').val(),
          'fee_payable' : row.closest('tr').find('.fee_payable').val(),
          'tax_payable' : row.closest('tr').find('.tax_payable').val(),
          'buyer_address' : row.closest('tr').find('.buyer_address').val()
        }
        console.log(data)
        var jqxhr = $.ajax({
          method: "POST",
          url: "{{ url('/api/updateProduction') }}/"+id,
          data : data
        })
        .done(function(obj){
          $.notify({icon: 'fa fa-info', message: 'Data updated'},{type: 'info', timer: 500, z_index: 2000,});
        })
      })

      $(document).on('click', 'a.remove-prod', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var row = $(this).parent().parent();
         var jqxhr = $.ajax({
          method: "POST",
          url: "{{ url('/api/deleteProduction') }}/"+id
        })
         .done(function(data){
          
          row.remove();
           $.notify({icon: 'fa fa-warning', message: data.message},{type: 'warning', timer: 500, z_index: 2000,});
         })
      });

      $('.add-production-row').on('click', function(e){
        e.preventDefault();
        var report_id = $('.report_id').val();
        var table = $('#production');
        table.prepend('<tr><td><input type="text" class="materials form-control"></td><td><input type="number" class="p_quantity  form-control"></td><td><input type="number" class="p_value  form-control"></td><td><input type="number" class="s_quantity  form-control"></td><td><input type="number" class="s_value form-control"></td><td><input type="number" class="mi_quantity  form-control"></td><td><input type="number" class="mi_value form-control"></td><td><input type="number" class="fee_payable form-control"></td><td><input type="number" class="tax_payable form-control"></td><td><input type="text" class="buyer_address form-control"></td><td><a class="btn btn-primary save-new-prod" data-id="'+report_id+'"><i class="fa fa-save"></i></a><a class="btn btn-warning remove-new-prod"><i class="fa fa-close"></i></a></td></tr>');
      })

      $(document).on('click', '.remove-new-prod', function(e){
        e.preventDefault();
        var row = $(this).parent().parent();
        // removes existing data
        var id = $(this).data('id');

        row.remove();
      })
      $(document).on('click', '.save-new-prod', function(e){
        e.preventDefault();
        counter = 0;
        var row = $(this).parent().parent();
        var table = $('#production');
        // removes existing data
        var id = $(this).data('id');
        var data = {
          'materials': row.closest('tr').find('.materials').val(),
          'p_quantity' :row.closest('tr').find('.p_quantity').val(),
          'p_value': row.closest('tr').find('.p_value').val(),
          's_quantity' : row.closest('tr').find('.s_quantity').val(),
          's_value' : row.closest('tr').find('.s_value').val(),
          'mi_quantity' : row.closest('tr').find('.mi_quantity').val(),
          'mi_value' : row.closest('tr').find('.mi_value').val(),
          'fee_payable' : row.closest('tr').find('.fee_payable').val(),
          'tax_payable' : row.closest('tr').find('.tax_payable').val(),
          'buyer_address' : row.closest('tr').find('.buyer_address').val()
        }
        row.remove();

        var jqxhr = $.ajax({
          method: "POST",
          url: "{{ url('/api/createProduction') }}/"+id,
          data : data
        })
        .done(function(data){
          $.notify({icon: 'fa fa-info', message: data.message},{type: 'info', timer: 500, z_index: 2000,});
          table.prepend('<tr><td><input type="text" class="materials form-control" value="'+data.production.materials+'"></td><td><input type="number" class="p_quantity  form-control" value="'+data.production.p_quantity+'"></td><td><input type="number" class="p_value  form-control" value="'+data.production.p_value+'"></td><td><input type="number" class="s_quantity  form-control" value="'+data.production.s_quantity+'"></td><td><input type="number" class="s_value form-control" value="'+data.production.s_value+'"></td><td><input type="number" class="mi_quantity  form-control" value="'+data.production.mi_quantity+'"></td><td><input type="number" class="mi_value form-control" value="'+data.production.mi_value+'"></td><td><input type="number" class="fee_payable form-control" value="'+data.production.fee_payable+'"></td><td><input type="number" class="tax_payable form-control" value="'+data.production.tax_payable+'"></td><td><input type="text" class="buyer_address form-control" value="'+data.production.buyer_address+'"></td><td><a class="btn btn-primary save-prod" data-id="'+data.production.id+'"><i class="fa fa-save"></i></a><a class="btn btn-warning remove-prod" data-id="'+data.production.id+'"><i class="fa fa-close"></i></a></td></tr>');
        })
      })

       $('.update-report').on('click', function(e){
        e.preventDefault();
        var report_id = $('.report_id').val();
        var jqxhr = $.ajax({
          method: "POST",
          url: "{{ url('/api/updateReport') }}/"+report_id,
          data : {
            'api_token' : "{{ Auth::user()->api_token }} ",
            'user_id':  {{ Auth::user()->id }},
            'masterlist_id': {{ $masterlist->id }},
            'date': $('.date').val(),
            'days_of_operation': $('.days_of_operation').val(),
            'prepared_by' : $('.prepared_by').val(),
            'o_male' : $('.o_male').val(),
            'o_female' : $('.o_female').val(),
            's_male' : $('.s_male').val(),
            's_female' : $('.s_female').val(),
          }
        })
        .done(function(data){
          if(data.type == 'success'){
            $.notify({icon: 'fa fa-info', message: data.message},{type: 'info', timer: 500, z_index: 2000,});
            $('#reportModalShow').modal('hide');
          }else{
            alert(data.message)
          }
        })


      })


    })
    
  </script>
  