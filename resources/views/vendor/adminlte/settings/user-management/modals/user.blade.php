 <div class="modal fade" id="user-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">User Data</h4>
        </div>
        <div class="modal-body">
        <box class="header">
          <p class="action-name">Create New User</p>
        </box>
          <div class="box-body">
            <input type="hidden" class="action-type" value="create-new">
            <input type="hidden" class="user-id">
            <div class="form-group">
              <label class="control-label">Name</label>
              <input type="text" name="name" class="form-control name" placeholder="Full name">
            </div>
            <div class="form-group">
              <label class="control-label">Email</label>
              <input type="email" name="email" class="form-control email" placeholder="email@email.com">
            </div>
            <div class="form-group">
              <label class="control-label">Role</label>
              <select name="role" class="form-control role">
                <option value="0">Encoder</option>
                <option value="1">Billing</option>
                <option value="2">GeoSciences Admin</option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Status</label>
              <select name="status" class="form-control status">
                <option value="0">Deactivated</option>
                <option value="1">Active</option>
              </select>
            </div>
            <div class="form-group">
              <a class="btn btn-primary reset-password"><i class="fa fa-refresh"></i> Reset Password</a>
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button id="save-user" type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <script type="text/javascript">
    $(function(){

      $('.reset-password').on('click', function(e){
        e.preventDefault();
        var id = $('.user-id').val()

        location.href = "{{ url('/settings/resetPassword') }}/"+id;
      })

      $('#save-user').on('click', function(e){
        e.preventDefault();
        var action = $('.action-type').val();
        var user_id = $('.user-id').val();
        var name = $('.name').val();
        var email = $('.email').val();
        var role = $('.role').val();
        var status = $('.status').val();
        var data = {
          'user_id' : user_id,
          'name' : name,
          'email' : email,
          'role' : role,
          'status' : status,
          'api_token' : "{{Auth::user()->api_token}}",
          'auth_role' : {{Auth::user()->role}}
        }
        if(action === 'update'){
          var jqxhr = $.ajax({
            method: "POST",
            url: "{{ url('/api/user') }}/"+user_id,
            data : data
          })
          .done(function(data){
            if(data.type == 'success'){
              alert(data.message, data.type)
            }else{
              alert(data.message, data.type)
            }
            location.reload();
          });
        }else{
          var jqxhr = $.ajax({
            method: "POST",
            url: "{{ url('/api/createUser') }}",
            data : data
          })
          .done(function(data){
            if(data.type == 'success'){
              alert(data.message, data.type)
            }else{
              alert(data.message, data.type)
            }
            location.reload();
          })
        }
      });
    });
  </script>
