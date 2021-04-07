@extends('adminlte::layouts.app')

@section('htmlheader_title', 'Billing')
@section('contentheader_title', 'Billing')
@section('module', 'Billing')
@section('level', 'Pending')

@section('main-content')
	 <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Billing List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="masterlist" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Business Name</th>
                  <th>Owner</th>
                  <th>Address</th>
                  <th>Type</th>
                  <th>Payables</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $row)
                <tr>
                  <td> <a href="{{ url('/billing').'/'.$row->id }}"> {{ $row->business_name }}</a></td>
                  <td>{{ $row->owner_name }}</td>
                  <td>{{ $row->prk.' '.$row->brgy.', '.$row->municipality.' '.$row->province.', '.$row->island }}</td>
                  <td>{{ App\Permittype::getDetails($row->permittype_id)->name }}</td>
                  <td><span class="badge bg-red">{{ count(App\Billing::where('masterlist_id', $row->id)->where('status', 0)->get()) }}/{{ count($row->billings) }} Payables</span> </td>
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
  });
</script>
@endsection
