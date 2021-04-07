
@extends('adminlte::layouts.app')

@section('htmlheader_title', 'Reports')
@section('contentheader_title', 'Reports')
@section('module', 'Reports')
@section('level', 'index')

@section('main-content')
	<section class="col-md-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class="active"><a href="#sales-report" data-toggle="tab">Sales</a></li>
            </ul>
            <div class="tab-content">
              @include('adminlte::reports.partials.sales')
            </div>
          </div>
    </section>
	  

@endsection
@section('customjs')
<script type="text/javascript">
  $(function(){
    $('#sales-report').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
  });
</script>
@endsection
