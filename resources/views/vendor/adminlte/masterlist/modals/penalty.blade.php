 <div class="modal fade" id="penalty-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Payment </h4><small>Penalty Billing</small>
        </div>
        <div class="modal-body">
        <box class="header">
        <input type="hidden" class="method-type">
          <input class="form-control fee-name" placeholder="Description"></input>
        </box>
          <div class="box-body">
            <input type="hidden" class="fee-id">
            <div class="form-group">
              <label class="control-label">Fee : </label>
              <input class="form-control fee-price" type="number" placeholder="Penalty Amount">
            </div>
            <div class="form-group">
              <label class="control-label"> OR # : </label>
              <input class="form-control fee-or-no" type="text" placeholder="OR number">
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button id="pay-fee" type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
 
  <script type="text/javascript">
    $(function(){
      var table = $('#penalties');
      $('#pay-fee').on('click', function(e){
        var method = $('.method-type').val();
        if(method == 'new'){
          var jqxhr = $.ajax({
            method: "POST",
            url: "{{ url('/api/penalty/addPost') }}",
            data : {
              'api_token' : "{{ Auth::user()->api_token }} ",
              'user_id':  {{ Auth::user()->id }},
              'masterlist_id': {{ $masterlist->id }},
              'fee' : $('.fee-price').val(),
              'or_no' : $('.fee-or-no').val(),
              'name' : $('.fee-name').val()
            }
          })
          .done(function(data){
            if(data.type == 'success'){
              var fee = data.bill.fee;
              table.prepend('<tr id="penalty-'+data.bill.id+'"><td><a class="trigger-penalty-modal" data-toggle="modal" data-target="#penalty-modal" data-id="'+data.bill.id+'">'+data.bill.id+'</a></td><td>'+data.bill.name+'</td><td>'+Number(fee).toFixed(2)+'</td><td><span class="badge bg-red">Pending</span></td> </tr>');
              $.notify({icon: 'fa fa-info', message: data.message},{type: 'info', timer: 500, z_index: 2000,});
              $('#penalty-modal').modal('hide')
            }else{
              $.notify({icon: 'fa fa-warning', message: data.message},{type: 'warning', timer: 500, z_index: 2000,});
            }
          })

        }else{
          var id = $('.fee-id').val()
          var jqxhr = $.ajax({
            method: "POST",
            url: "{{ url('/api/penalty/') }}/"+id,
            data : {
              'api_token' : "{{ Auth::user()->api_token }} ",
              'user_id':  {{ Auth::user()->id }},
              'masterlist_id': {{ $masterlist->id }},
              'fee' : $('.fee-price').val(),
              'or_no' : $('.fee-or-no').val(),
              'name' : $('.fee-name').val()
            }
          })
          .done(function(data){
            if(data.type == 'success'){
              var fee = data.bill.fee;
              $('#penalty-'+data.bill.id).remove()
              var stats = '<td><span class="badge bg-blue">Paid</span></td>';
              if(data.bill.status == 0){
                stats = '<td><span class="badge bg-red">Pending</span></td>'
              }
              table.prepend('<tr id="penalty-'+data.bill.id+'"><td><a class="trigger-penalty-modal" data-toggle="modal" data-target="#penalty-modal" data-id="'+data.bill.id+'">'+data.bill.id+'</a></td><td>'+data.bill.name+'</td><td>'+Number(fee).toFixed(2)+'</td>'+stats+'</tr>');
              $.notify({icon: 'fa fa-info', message: data.message},{type: 'info', timer: 500, z_index: 2000,});
              $('#penalty-modal').modal('hide')
            }else{
              $.notify({icon: 'fa fa-warning', message: data.message},{type: 'warning', timer: 500, z_index: 2000,});
            }
          })
        }
      })
    })
  </script>

