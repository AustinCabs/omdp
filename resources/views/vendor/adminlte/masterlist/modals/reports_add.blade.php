  <div class="modal fade" id="reportModalAdd">
    <div class="modal-dialog modal-lg">
      <form id="#ReportForm" method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Sales and Production Report</h4>
          </div>
          
            <div class="modal-body">
              
              
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
                      <a class="btn btn-primary pull-right add-sales-row"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="box-body">
                      <table class="table table-bordered" id="sales">
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
                          <td>Value (P)</td>                  </tr>
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
              <button type="button" class="btn btn-primary save-report">Save changes</button>
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
      // production table codes
      var production = [];
      $('.add-sales-row').on('click', function(e){
        e.preventDefault();
        var table = $('#sales');
        table.prepend('<tr><td><input type="text" class="materials form-control"></td><td><input type="number" class="p_quantity  form-control"></td><td><input type="number" class="p_value  form-control"></td><td><input type="number" class="s_quantity  form-control"></td><td><input type="number" class="s_value form-control"></td><td><input type="number" class="mi_quantity  form-control"></td><td><input type="number" class="mi_value form-control"></td><td><input type="number" class="fee_payable form-control"></td><td><input type="number" class="tax_payable form-control"></td><td><input type="text" class="buyer_address form-control"></td><td><a class="btn btn-primary save"><i class="fa fa-save"></i></a><a class="btn btn-warning remove"><i class="fa fa-close"></i></a></td></tr>');
      });

      $(document).on('click', '.remove', function(e){
        e.preventDefault();
        var row = $(this).parent().parent();
        // removes existing data
        var id = $(this).data('id');
        if(id){
          idx = production.findIndex(x => x.materials === id);
          production.splice(idx, 1);
          console.log(production);
        }
        row.remove();
      })
      $(document).on('click', '.save', function(e){
        e.preventDefault();
        counter = 0;
        var row = $(this).parent().parent();
        var table = $('#sales');
        // removes existing data
        var id = $(this).data('id');
        if(id){
          idx = production.findIndex(x => x.materials === id);
          production.splice(idx, 1);
        }
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

        production.push(data);
        console.log(production)
        row.remove();
        table.prepend('<tr><td>'+data.materials+'</td><td>'+data.p_quantity+'</td><td>'+data.p_value+'</td><td>'+data.s_quantity+'</td><td>'+data.s_value+'</td><td>'+data.mi_quantity+'</td><td>'+data.mi_value+'</td><td>'+data.fee_payable+'</td><td>'+data.tax_payable+'</td><td>'+data.buyer_address+'</td><td><a class="btn btn-primary edit" data-id="'+data.materials+'"><i class="fa fa-edit"></i></a><a class="btn btn-warning remove" data-id="'+data.materials+'"><i class="fa fa-close"></i></a></td></tr>');

      })

      $(document).on('click', '.edit', function(e){
        e.preventDefault();
        var row = $(this).parent().parent();
        var table = $('#sales');
        var id = $(this).data('id');
        idx = production.findIndex(x => x.materials === id);
        data = production[idx];
        row.remove()
        table.prepend('<tr><td><input type="text" class="materials form-control" value="'+data.materials+'"></td><td><input type="number" class="p_quantity  form-control" value="'+data.p_quantity+'"></td><td><input type="number" class="p_value  form-control" value="'+data.p_value+'"></td><td><input type="number" class="s_quantity  form-control" value="'+data.s_quantity+'"></td><td><input type="number" class="s_value form-control" value="'+data.s_value+'"></td><td><input type="number" class="mi_quantity  form-control" value="'+data.mi_quantity+'"></td><td><input type="number" class="mi_value form-control" value="'+data.mi_value+'"></td><td><input type="number" class="fee_payable form-control" value="'+data.fee_payable+'"></td><td><input type="number" class="tax_payable form-control" value="'+data.tax_payable+'"></td><td><input type="text" class="buyer_address form-control" value="'+data.buyer_address+'"></td><td><a class="btn btn-primary save" data-id="'+data.materials+'"><i class="fa fa-save"></i></a><a class="btn btn-warning remove" data-id="'+data.materials+'"><i class="fa fa-close"></i></a></td></tr>');
      })

      

      $('.save-report').on('click', function(e){
        e.preventDefault();
        var jqxhr = $.ajax({
          method: "POST",
          url: "{{ url('/api/addMonthlyReport') }}/"+{{ $masterlist->id }},
          data : {
            'api_token' : "{{ Auth::user()->api_token }} ",
            'user_id':  {{ Auth::user()->id }},
            'masterlist_id': {{ $masterlist->id }},
            'production': JSON.stringify(production),
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
            alert(data.message)
            location.reload();
          }else{
            alert(data.message)
          }
        })


      })


    })
    
  </script>
  