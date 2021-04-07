@extends('adminlte::layouts.app')

@section('htmlheader_title', 'Announcement Settings')
@section('contentheader_title', 'Announcement Settings')
@section('module', 'Announcement Control Panel')
@section('level', 'control panel')

@section('main-content')
	 <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Announcement List</h3>
              <a data-toggle="modal" data-target="#ann-modal" class="pull-right btn btn-primary">
                <i class="fa fa-plus"></i> New Annoouncement
              </a>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- /.box-header -->
            <div class="box-body">
              <table id="annon" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($announcements as $row)
                  <tr>
                    <td>{{ $row->name }}</td>
                    <td>{{ date("M d Y ", strtotime( $row->date)) }}</td>
                    <td><a href="{{ url('/settings/announcement-delete/').'/'.$row->id }}" class="btn btn-warning"><i class="fa fa-trash"></i> Delete</a></td>
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
@include('adminlte::settings.portal.modals.announce')
@endsection
@section('customjs')
<script type="text/javascript">
  $(function(){
    $('#annon').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
  });
</script>
@endsection

