@extends('adminlte::layouts.app')

@section('htmlheader_title', 'Masterlist')
@section('contentheader_title', 'Masterlist Dashboard')
@section('module', 'Masterlist')
@section('level', 'Home')

@section('main-content')
	 <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Masterlist Data</h3>
              <a href="{{ url('/masterlist/addGet') }}" class="pull-right btn btn-primary">
                <i class="fa fa-user-plus"></i> New Application
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="masterlist" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Query Code</th>
                  <th>Business Name</th>
                  <th>Owner</th>
                  <th>Address</th>
                  <th>Permit</th>
                  <th>Application Type</th>
                  <th>Status</th>
                  @if (Auth::user()->role == 2 || Auth::user()->role == 3)
                    <th>Update</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                @foreach($masterlist as $row)
                <tr>
                  <td>{{ $row->query_code }}</td>
                  <td> <a href="{{ url('/masterlist').'/'.$row->id }}"> {{ $row->business_name }}</a></td>
                  <td>{{ $row->owner_name }}</td>
                  <td>{{ $row->prk.' '.$row->brgy.', '.$row->municipality.' '.$row->province.', '.$row->island }}</td>
                  <td>{{ App\Permittype::getDetails($row->permittype_id)->name }}</td>
                  <td>
                    @if ($row->application_type == 0)
                        <span class="label label-primary">New</span>
                    @else
                        <span class="label label-primary">Renewal</span>
                     @endif
                  </td>
                  <td>
                    @if($row->status == 0)
                      <span class="label label-warning">Pending</span>
                    @elseif($row->status == 1)
                      <span class="label label-primary">Approved</span>
                    @else
                      <span class="label label-danger">Denied</span>
                    @endif

                  </td>
                  @if (Auth::user()->role == 2 || Auth::user()->role == 3)
                    <td>
                      @if (App\MasterChecklist::where('masterlist_id', $row->id)->where('status', 1)->count() == App\MasterChecklist::where('masterlist_id', $row->id)->count() && $row->status != 1 && App\Billing::where('masterlist_id', $row->id)->where('status', 1)->count() == App\Billing::where('masterlist_id', $row->id)->count())
                        <span class="label label-primary">For Approval</span>
                      @elseif($row->status == 1 && strtotime(date('Y-m-d')) > strtotime($row->expiry_date))
                        <span class="label label-warning">Expired </span>
                      @elseif($row->status == 1)
                         <span class="label label-primary">Done</span>
                      @else
                        <span class="label label-warning">Pending</span>
                      @endif
                    </td>
                  @endif
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
