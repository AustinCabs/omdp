<div class="chart tab-pane active" id="masterlist-reports" style="position: relative; height: 300px;">
	<div class="box">
		<div class="box-header">
			<h4>Permitee Masterlist</h4>
			<div class="btn-group pull-right">
				<a class="btn btn-primary" data-toggle="modal" data-target="#permiteeFilters"><i class="fa fa-filter"></i> Filter List</a>
				<a class="btn btn-primary" href="{{ url('reports') }}"> <i class="fa fa-refresh"></i></a>
				<a class="btn btn-primary"> <i class="fa fa-print"></i></a>	
			</div>
			
		</div>
		<div class="box-body">
			<table class="table table-hover" id="masterlist-report">
				<thead>
					<tr>
						<th>Business Name</th>
						<th>Owner</th>
						<th>Location</th>
						<th>Type</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					@foreach($masterlist as $row)
					<tr>
						<td> <a href="{{ url('/masterlist').'/'.$row->id }}"> {{ $row->business_name }}</a></td>
			              <td>{{ $row->owner_name }}</td>
			              <td>{{ $row->prk.' '.$row->brgy.', '.$row->municipality.' '.$row->province.', '.$row->island }}</td>
			              <td>{{ App\Permittype::getDetails($row->permittype_id)->name }}</td>
			              <td>
			                @if($row->status == 0)
			                  <span class="label label-warning">Pending</span>
			                @elseif($row->status == 1)
			                  <span class="label label-primary">Approved</span>
			                @else
			                  <span class="label label-danger">Denied</span>
			                @endif

			              </td>
					</tr>
					@endforeach
				</tbody>
			</table>  
			
		</div>
	</div>
</div>
@include('adminlte::reports.modals.permit_filter')