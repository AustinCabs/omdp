@extends('adminlte::layouts.app')

@section('htmlheader_title', 'Messages')
@section('contentheader_title', 'Direct Messages')
@section('module', 'Messages')
@section('level', 'Dashboard')

@section('main-content')
	 <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Direct Messages Dashboard</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="masterlist" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Contact</th>
                  <th>Date</th>
                  <th>Status</th>
                </tr>
                </thead>
                  
                <tbody>
                @foreach ($chats as $row)
                    <tr>
                      <td><a class="read-msg" data-id="{{ $row->id }}">{{ $row->contact }}</a></td>
                      <td>{{ Carbon\Carbon::createFromTimeStamp(strtotime($row->created_at))->diffForHumans()  }}</td>
                      <td>
                        @if ($row->status == 0)
                          <span class="label label-warning">New</span>
                        @else
                          <span class="label label-primary">Checked</span>
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
      @include('adminlte::chat.modals.msg')
@endsection
@section('customjs')
<script type="text/javascript">
  $(function(){
    $('#masterlist').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });


    $('.read-msg').on('click', function(e){
      e.preventDefault();
      var id = $(this).data('id')
      var user_id = "{{ Auth::user()->id }}";
      var api_token = "{{ Auth::user()->api_token}}";
      var jqxhr = $.ajax({
          method: "get",
          url: "{{ url('/api/msg/') }}/"+id,
          data : {
            'user_id': user_id,
            'api_token' : api_token
          }
        })
        .done(function(data){
          if(data.type == 'success'){
            $('.contact').val(data.msg.contact)
            $('.msg').val(data.msg.msg)
            $('#msg-modal').modal('show')
          }else{
            $.notify({icon: 'fa fa-warning', message: data.message},{type: 'warning', timer: 500, z_index: 2000,});
          }
        })
    })

  });
</script>
@endsection
