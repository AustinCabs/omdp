@extends('adminlte::layouts.app')

@section('htmlheader_title', 'User Management')
@section('contentheader_title', 'User Management')
@section('module', 'User Management')
@section('level', 'control panel')

@section('main-content')
	 <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Users List</h3>
              <a data-toggle="modal" data-target="#user-modal" class="pull-right btn btn-primary show-user-modal">
                <i class="fa fa-user-plus"></i> New User
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="userlist" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $row)
                <tr>
                  <td><a data-id="{{ $row->id }}" class="show-user">{{ $row->name }}</a></td>
                  <td>{{ $row->email }}</td>
                  <td>
                    @if ($row->role == 0)
                      <span class="badge bg-yellow">Encoder</span>
                    @elseif ($row->role == 1)
                      <span class="badge bg-red">Billing</span>
                    @elseif ($row->role == 2)
                      <span class="badge bg-green">GeoSciences Admin</span>
                    @elseif ($row->role == 3)
                      <span class="badge bg-blue">Superuser</span>
                    @endif
                  </td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
@include('adminlte::settings.user-management.modals.user')
@endsection
@section('customjs')
<script type="text/javascript">
  $(function(){
    $('#userlist').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
    $('.show-user-modal').on('click', function(e){
      e.preventDefault();
      $('.action-name').text('Create New User')
      $('.action-type').val('');
      $('.user-id').val('');
      $('.name').val('');
      $('.email').val('');
      $('.role').val(0);
      $('.status').val(0);
    })
    $('.show-user').on('click', function(e){
      e.preventDefault();
      var id = $(this).data('id')
      var jqxhr = $.ajax({
          method: "GET",
          url: "{{ url('/api/user') }}/"+id,
          data : {
            'api_token' : "{{ Auth::user()->api_token }} ",
            'role':  {{ Auth::user()->role }}
          }
        })
      .done(function(data){
        if(data.status == 'error'){
          alert(data.message)
        }else{
          $('.action-name').text('Update User')
          $('.action-type').val('update');
          $('.user-id').val(data.id);
          $('.name').val(data.name);
          $('.email').val(data.email);
          $('.role').val(data.role);
          $('.status').val(data.status);

          $('#user-modal').modal('show')
        }
        
      })
    })
  });
</script>
@endsection

