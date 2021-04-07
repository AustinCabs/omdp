<a class="btn btn-primary new-penalty" data-toggle="modal" data-target="#penalty-modal"><i class="fa fa-plus"></i> Add new</a>
<table class="table table-striped" id="penalties">
	<thead>
	<tr>
		<th>#</th>
		<th>Description</th>
		<th>Total</th>
		<th>Status</th>
	</tr>
	</thead>
	<tbody>
		@foreach ($penalties as $row)
			<tr id="penalty-{{$row->id}}">
				<td>
			        @if (Auth::user()->role == 1 || Auth::user()->role == 3)
			          <a class="trigger-penalty-modal" data-toggle="modal" data-target="#penalty-modal" data-id="{{ $row->id }}">{{ $row->id }}</a>
			        @else
			          {{ $row->id }}
			        @endif
			      </td>
				<td>{{ $row->name }}</td>
				<td>{{ number_format($row->fee, 2) }}</td>

	     
		        <td>
		        @if ($row->status == 0)
		          <span class="badge bg-red">Pending</span>
		        @else
		          <span class="badge bg-blue">Paid</span>
		        @endif
		        </td>
			</tr>
		@endforeach
	</tbody>
</table>
<script type="text/javascript">
	$(function(){
		$('#penalties').DataTable({
	      'paging'      : true,
	      'lengthChange': false,
	      'searching'   : true,
	      'ordering'    : true,
	      'info'        : true,
	      'autoWidth'   : false
	    });


	    $('.new-penalty').on('click', function(e){
	    	e.preventDefault();
	    	$('.method-type').val('new');
	    	$('.fee-or-no').attr('disabled',true);
	    	$('.fee-id').val(null);
        	$('.fee-name').val(null)
        	$('.fee-price').val(null)
        	$('.fee-or-no').val(null)
	    });

	    $(document).on('click', '.trigger-penalty-modal', function(e){
	    	e.preventDefault();
	    	$('.method-type').val('update');
	    	$('.fee-or-no').attr('disabled',false);

	    	var id = $(this).data('id')
	    	var jqxhr = $.ajax({
	            method: "GET",
	            url: "{{ url('/api/penalty') }}/"+id
	        })
	        .done(function(data){
	        	$('.fee-id').val(data.id);
	        	$('.fee-name').val(data.name)
	        	$('.fee-price').val(data.fee)
	        	$('.fee-or-no').val(data.or_no)
	        })
	    })
	})
</script>
@include('adminlte::masterlist.modals.penalty')
