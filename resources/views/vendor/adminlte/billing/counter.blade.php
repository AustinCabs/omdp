@extends('adminlte::layouts.app')

@section('htmlheader_title', 'Billing')
@section('contentheader_title', 'Counter')
@section('module', 'Billing')
@section('level', $masterlist->business_name )
@section('contentheader_description', 'Billing section')

@section('main-content')
	

    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            Provincial Environment Management Office
            <small class="pull-right">Date: {{ Date('Y-m-d') }}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <address>
            <strong> {{ $masterlist->owner_name }}</strong><br>
            {{ $masterlist->prk.' '.$masterlist->brgy.', '.$masterlist->municipality }} <br>
            {{ $masterlist->province }} <br>
            {{ $masterlist->contact_no }} <br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Type of Permit : </b> {{ App\Permittype::getDetails($masterlist->permittype_id)->name }} <br>
          <b>TIN # : </b> {{ $masterlist->tin_no }}
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
            <th>#</th>
              <th>Description</th>
              <th>Subtotal</th>
              @if (Auth::user()->role != 1)
                <th>Status</th>
              @endif
            </tr>
            </thead>
            <tbody>
            	@foreach ($billings as $row)
            		<tr>
            			<td>
                    @if (Auth::user()->role == 1 || Auth::user()->role == 3)
                      <a class="trigger-payment-modal" data-toggle="modal" data-target="#payment-modal" data-id="{{ $row->id }}">{{ $row->id }}</a>
                    @else
                      {{ $row->id }}
                    @endif
                  </td>
            			<td>{{ $row->name }}</td>
            			<td>{{ number_format($row->fee, 2) }}</td>

                  @if (Auth::user()->role != 1)
                    <td>
                    @if ($row->status == 0)
                      <span class="badge bg-red">Pending</span>
                    @else
                      <span class="badge bg-blue">Paid</span>
                    @endif
                    </td>
                  @endif
            		</tr>
            	@endforeach
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
      	<div class="col-xs-6"></div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead"></p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th>Total:</th>
                <td id="total-fee"> {{ number_format($total, 2) }}</td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
	
@endsection

@section('customjs')
<script type="text/javascript">
  $(function(){
    //triggers payment modal
    $('.trigger-payment-modal').on('click', function(e){
    	e.preventDefault();
    	var id = $(this).data('id');
    	var jqxhr = $.ajax({
          method: "get",
          url: "{{ url('/api/billing-details/') }}/"+id,
        })
        .done(function(data){
        	console.log(data)
        	$('.fee-name').text(data.name);
        	$('.fee-price').val(data.fee);
        	$('.fee-id').val(id);
          $('.fee-or-no').val(data.or_no)
        })
    });

    // save payment
    $('#pay-fee').on('click', function(e){
    	e.preventDefault();
    	var id = $('.fee-id').val()
    	var fee = $('.fee-price').val()
    	var or = $('.fee-or-no').val()
    	if( or && fee ){
    		var jqxhr = $.ajax({
	          method: "POST",
	          url: "{{ url('/api/billing-pay/') }}/"+id,
	          data : {
	          	'api_token' : "{{ Auth::user()->api_token }} ",
	          	'or_no' : or,
              'user_id':  {{ Auth::user()->id }}
	          }
	        })
	        .done(function(data){
	        	if(data.type == 'success'){
	        		$.notify({icon: 'fa fa-info', message: data.message},{type: 'info', timer: 500, z_index: 2000,});
	        	}else{
	        		$.notify({icon: 'fa fa-warning', message: data.message},{type: 'warning', timer: 500, z_index: 2000,});
	        	}
	        });
	     window.location.reload();
    	}else{
    		alert("Please type the OR #")
    	}

    })
  });
</script>
@endsection
@include('adminlte::billing.modals.payment')
