<div class="modal fade" id="changepass" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Password</h4>
        </div>
        <div class="modal-body">
          <form>
          <div id="admin-error">
            
          </div>
            <div class="row">
              <div class="col-md-12 pr-1">
                <div class="form-group">
                  <p>Old Password</p>
                  <input type="password" class="form-control password" placeholder="Password">
                </div>
              </div>
              <div class="col-md-12 pr-1">
                <div class="form-group">
                  <p>New Password</p>
                  <input type="password" class="form-control password1" placeholder="New password">
                </div>
              </div>
              <div class="col-md-12 pr-1">
                <p>Confirm Password</p>
                <input type="password" class="form-control password2" placeholder="Confirm new password">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
        <a id="save-changes" class="btn btn-primary btn-fill pull-left" type="button">Save Changes</a>
            <button type="button" class="btn btn-fill btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<script type="text/javascript">
  $(function(){
    $('#save-changes').on('click', function(e){
      e.preventDefault();
      var jqxhr = $.ajax({
            method: "POST",
            url: "{{ url('/api/profile/change-password') }}",
            data: { 
              "_token": "{{ csrf_token() }}", 
              "id": "{{ Auth::user()->id }}",
              "password": $('.password').val(),
              "password1": $('.password1').val(),
              "password2": $('.password2').val(),
               }
          })
        .done(function(data){
          $('.password2').val('');
          $('.password1').val('');
          $('.password').val('');
          if(data.status === 'error'){
            $.notify({icon: 'fa fa-warning', message: data.message},{type: 'warning', timer: 500, z_index: 2000,});
          }else{
            $('#changepass').modal('hide');
            $.notify({icon: 'fa fa-check', message: 'New password saved'},{type: 'success', timer: 500});
          }
        });
    })
  });
</script>