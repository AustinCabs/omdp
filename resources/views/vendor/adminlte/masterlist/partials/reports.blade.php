<a class="btn btn-primary" data-toggle="modal" data-target="#reportModalAdd"><i class="fa fa-plus"></i> Add new</a>
<table id="reports" class="table table-stripped">
	<thead>
		<tr>
			<th>Date</th>
			<th>Days of Operation</th>
			<th>Prepared By</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach ($reports as $row)
			<tr>
				<td>{{ date("M Y", strtotime( $row->date) ) }}</td>
				<td>{{ $row->days_of_operation }} Days</td>
				<td>{{ $row->prepared_by }}</td>
				<td>
					<a class="btn btn-primary show-report" data-id="{{ $row->id }}"> <i class="fa fa-eye"></i> Show</a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>
<script type="text/javascript">
	$(function(){
		$('#reports').DataTable({
	      'paging'      : true,
	      'lengthChange': false,
	      'searching'   : true,
	      'ordering'    : true,
	      'info'        : true,
	      'autoWidth'   : false
	    });

	    $('.show-report').on('click', function(e){
	    	e.preventDefault();
	    	var id = $(this).data('id')
	    	var jqxhr = $.ajax({
	          method: "GET",
	          url: "{{ url('/api/getReport') }}/"+id
	        })
	        .done(function(data){
	        	var table = $('#production');
	        	$('#production tbody').empty();
	        	var idx = data.production.length;
				$('.date').val(data.report.date)
            	$('.days_of_operation').val(data.report.days_of_operation)
            	$('.prepared_by').val(data.report.prepared_by)
        		$('.o_male').val(data.employment[0].o_male)
            	$('.o_female').val(data.employment[0].o_female)
           		$('.s_male').val(data.employment[0].s_male)
            	$('.s_female').val(data.employment[0].s_female)
            	$('.report_id').val(data.report.id)
            	for (var i = 0; i < idx; i++){

            		 table.prepend('<tr><td><input type="text" class="materials form-control" value="'+data.production[i].materials+'"></td><td><input type="number" class="p_quantity  form-control" value="'+data.production[i].p_quantity+'"></td><td><input type="number" class="p_value  form-control" value="'+data.production[i].p_value+'"></td><td><input type="number" class="s_quantity  form-control" value="'+data.production[i].s_quantity+'"></td><td><input type="number" class="s_value form-control" value="'+data.production[i].s_value+'"></td><td><input type="number" class="mi_quantity  form-control" value="'+data.production[i].mi_quantity+'"></td><td><input type="number" class="mi_value form-control" value="'+data.production[i].mi_value+'"></td><td><input type="number" class="fee_payable form-control" value="'+data.production[i].fee_payable+'"></td><td><input type="number" class="tax_payable form-control" value="'+data.production[i].tax_payable+'"></td><td><input type="text" class="buyer_address form-control" value="'+data.production[i].buyer_address+'"></td><td><a class="btn btn-primary save-prod" data-id="'+data.production[i].id+'"><i class="fa fa-save"></i></a><a class="btn btn-warning remove-prod" data-id="'+data.production[i].id+'"><i class="fa fa-close"></i></a></td></tr>');
        		}

	        	$('#reportModalShow').modal('show');
 
	        })
	    })
	});
</script>
@include('adminlte::masterlist.modals.reports_add')
@include('adminlte::masterlist.modals.reports_show')