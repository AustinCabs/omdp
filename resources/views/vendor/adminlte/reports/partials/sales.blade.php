<div class="tab-pane active" id="masterlist-reports" style="position: relative; height: 300px;">
	<div class="box">
		<div class="box-header">
			<h4>Production and Sales Report</h4>
			<div class="btn-group pull-right">
				<a class="btn btn-primary" data-toggle="modal" data-target="#permiteeFilters"><i class="fa fa-filter"></i> Filter List</a>
				<a class="btn btn-primary" href="{{ url('reports') }}"> <i class="fa fa-refresh"></i></a>
				<a class="btn btn-primary" data-toggle="modal" data-target="#printMonthlyReport"> <i class="fa fa-print"></i></a>	
			</div>
			
		</div>
		<div class="box-body">
			<table class="table table-hover" id="sales-report">
				<thead>
					<tr>
						<th>Date</th>
						<th>Business Name</th>
						<th>Owner</th>
						<th>Location</th>
						<th>Type</th>
					</tr>
				</thead>
				<tbody>
					@foreach($reports as $row)
					<tr>
						<td>{{ date("M Y", strtotime( $row->date)) }}</td>
						<td>{{ $row->masterlist->business_name }}</td>
						<td>{{ $row->masterlist->owner_name }}</td>
						<td>{{ $row->masterlist->prk.' '.$row->masterlist->brgy.', '.$row->masterlist->municipality.' '.$row->masterlist->province.', '.$row->masterlist->island }}</td>
                  		<td>{{ App\Permittype::getDetails($row->masterlist->permittype_id)->name }}</td>
					</tr>

					@endforeach
				</tbody>
			</table>  
			
		</div>
	</div>
</div>
@include('adminlte::reports.modals.permit_filter')
@include('adminlte::reports.modals.print_monthly_report')