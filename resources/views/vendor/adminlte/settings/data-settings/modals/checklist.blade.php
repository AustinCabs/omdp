<div class="modal fade" id="checklist">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title permit-name"></h4> <small>Permit Settings</small>
      </div>
      <div class="modal-body">
       <div class="box with-border">
        <div class="box-header">
          <h3 class="box-title"> <i class="fa fa-check-square"></i> Requirements</h3>
        </div>
        <div class="box-body">
          <div class="content table-responsive table-full-width">
          <input type="hidden" class="permit-id">
            <table class="table table-hover" id="requirements-tbl">
                 <tbody>
                 
                 </tbody>
            </table>
            

        </div>
        </div>
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <a class="btn btn-primary add-checklist pull-right"><i class="fa fa-plus"></i> Add Requirement</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script type="text/javascript">
  $(function(){
    var table = $('#requirements-tbl');
    $(document).on('click', '.delete-req', function(e){
      e.preventDefault();
      var id = $(this).data('id')
      if (confirm('Are you sure you want to delete this requirement permanently?')) {
          var jqxhr = $.ajax({
            method: "post",
            url: "{{ url('/api/deleteCheck/') }}/"+id,
            data: { 'api_token' : '{{ Auth::user()->api_token }}'}
          })
          .done(function(data){
            $('#checklist-'+id).remove()
            if(data.type == 'success'){
              $.notify({icon: 'fa fa-info', message: data.message},{type: 'info', timer: 500, z_index: 2000,});
            }else{
              $.notify({icon: 'fa fa-warning', message: data.message},{type: 'warning', timer: 500, z_index: 2000,});
            }
          }) 
      } else {
          
      }
      
    })

    $('.add-checklist').on('click', function(e){
      e.preventDefault();
      
      table.prepend('<tr><td><input type="text" class="form-control req-name"></td><td><a class="btn btn-primary save-req"> <i class="fa fa-save"></i></a></td><td><a class="btn btn-warning cancel-req"><i class="fa fa-close"></i></a></td></tr>');
    });

    $(document).on('click', '.cancel-req', function(e){
      e.preventDefault()
      $(this).parent().parent().remove()
    })

    $(document).on('click', '.save-req', function(e){
      e.preventDefault();
      var id = $('.permit-id').val()
      var jqxhr = $.ajax({
            method: "post",
            url: "{{ url('/api/saveCheck/') }}/"+id,
            data: { 'api_token' : '{{ Auth::user()->api_token }}', name : $('.req-name').val() }
          })
          .done(function(data){
            $(e.target).parent().parent().remove()
            if(data.type == 'success'){
              $.notify({icon: 'fa fa-info', message: data.message},{type: 'info', timer: 500, z_index: 2000,});
              table.append('<tr id="checklist-'+data.check.id+'"><td>'+data.check.name+'</td><td><a class="delete-req" data-id="'+data.check.id+'"><i class="fa fa-close"></i></a></td></tr>')
            }else{
              $.notify({icon: 'fa fa-warning', message: data.message},{type: 'warning', timer: 500, z_index: 2000,});
            }
          }) 
    })
  })
</script>