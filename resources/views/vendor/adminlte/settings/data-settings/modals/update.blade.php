 <div class="modal fade" id="update-bill">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title bill-name"></h4> <small>Permit Settings</small>
              </div>
              <div class="modal-body">
                <div class="box">
                  <div class="box-header">
                    <div class="form-group">
                      <div class="col-md-6">
                        <input type="hidden" class="permit-id">
                        <label class="control-label">Type :</label>
                        <select class="form-control permit-type">
                          <option value="0">Mining</option>
                          <option value="1">Quarry</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label class="control-label">Document: </label>
                        <input class="form-control" type="file">
                      </div>
                    </div>
                  </div>
                  <div class="box-body">
                    <table class="table table-hover table-striped" id="billing-types">
                      <thead><th></th><th></th><th class="pull-right">
                      <a class="btn btn-primary add-new-bill"><i class="fa fa-plus"></i></a></th></thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  </div>
                </div>

                
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger delete-permit">Delete Permit</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
<script type="text/javascript">
  $(function(){
    var table = $('#billing-types');
    $('.add-new-bill').on('click', function(e){
      e.preventDefault()
      table.prepend('<tr><td><input class="form-control bill-name"></td><td class="fee-container"><input class="form-control bill-fee" type="number" value=""></td><td><a class="btn btn-primary save-new-bill"><i class="fa fa-save"></i></a><a class="btn btn-warning cancel"><i class="fa fa-close"></i></a></td></tr>')
    })

    $(document).on('click', '.cancel', function(e){
      e.preventDefault();
      $(this).parent().parent().remove();
    })


    $(document).on('click', '.delete-bill', function(e){
      e.preventDefault()
      var id = $(this).data('id')
      var parent = $(this).parent()
      var jqxhr = $.ajax({
        method: "POST",
        url: "{{ url('/api/bill-delete/') }}/"+id,
        data : {'api_token' : '{{ Auth::user()->api_token }}' },
      })
      .done(function(data){
        if(data.type == 'success'){
          parent.parent().remove();
          $.notify({icon: 'fa fa-info', message: data.message},{type: 'info', timer: 500, z_index: 2000,});
        }else{
          $.notify({icon: 'fa fa-warning', message: data.message},{type: 'warning', timer: 500, z_index: 2000,});
        }
        
      })
    })


    $(document).on('click', '.save-new-bill', function(e){
      e.preventDefault();
      var id = $('.permit-id').val()
      var parent = $(this).parent();
      name = parent.closest('td').siblings().find('input.bill-name').val();
      fee = parent.closest('td').siblings().find('input.bill-fee').val();
      var jqxhr = $.ajax({
        method: "POST",
        url: "{{ url('/api/save-new-bill/') }}/"+id,
        data : { 'name': name, 'fee' : fee, 'api_token' : '{{ Auth::user()->api_token }}' },
      })
      .done(function(data){
        if(data.type == 'success'){
          parent.parent().remove();
          table.prepend('<tr><td>'+data.data.name+'</td><td class="fee-container"><input class="form-control bill-fee" type="number" value="'+data.data.fee+'"></td><td><a data-id="'+data.data.id+'" class="btn btn-primary save-bill-fee"><i class="fa fa-save"></i></a></td></tr>')
          $.notify({icon: 'fa fa-info', message: data.message},{type: 'info', timer: 500, z_index: 2000,});
        }else{
          $.notify({icon: 'fa fa-warning', message: data.message},{type: 'warning', timer: 500, z_index: 2000,});
        }
        
      })
    })

    $('.delete-permit').on('click', function(e){
      e.preventDefault()
      if (confirm('Are you sure you want to delete this permit permanently?')) {
          var id = $('.permit-id').val()
          window.location.href = "{{ url('/settings/delete-permit/') }}"+"/"+id;
      } else {
          
      }
    })


  })
</script>