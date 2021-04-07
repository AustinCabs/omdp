
<div class="active tab-pane" id="permit">
  <div class="box"> 
    <div class="box-header">
      <h3 class="box-title">Business Data</h3>
    </div>
    <div class="box-body">
      <div class="form-group">
        <div class="col-md-6">
          <label class="control-label">Date filed :</label>
           <input id="date_filed" type="text" class="form-control" name="date_filed" value="{{ $masterlist->date_filed }}" placeholder="Date filed" disabled>
        </div>
        <div class="col-md-6">
          <label class="control-label">Tin No. :</label>
          <input type="number" class="form-control" name="tin_no" placeholder="Tin Number" value="{{ $masterlist->tin_no }}" disabled>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-6">
          <label class="control-label">Contact No. :</label>
          <input class="form-control" name="contact_no" data-inputmask='"mask": "0999-999-9999"' data-mask value="{{ $masterlist->contact_no }}" placeholder="Contact No" disabled>
        </div>
       {{--<div class="col-md-6">
          <label class="control-label">Type :</label>
          <input type="text" class="form-control" name="type" value="{{ App\Type::type($masterlist->type)->name }}" disabled>
        </div>--}}
      </div>
      <div class="form-group">
        <div class="col-md-6">
          <label class="control-label">Total Area (square mtrs) :</label>
          <input class="form-control" type="number" name="area_volume" value="{{ $masterlist->area_volume }}" placeholder="Total Area" disabled>
        </div>
      </div>
      @if ($masterlist->status == 1 )
        <div class="form-group">
          <div class="col-md-6">
            <label class="control-label">Expiry Date :</label>
            <input class="form-control" type="text" name="expiry_date" value="{{ date("M jS, Y", strtotime( $masterlist->expiry_date)) }}" disabled></input>
          </div>
        </div>
      @endif
    </div>
  </div>

  <div class="box with-border">
    <div class="box-header">
      <h3 class="box-title"> <i class="fa fa-check-square"></i> Requirements</h3>
    </div>
    <div class="box-body">
      <div class="content table-responsive table-full-width">
        <table class="table table-hover" id="requirements-tbl">
             <tbody>
             @if( count($checklist) == 0):
              <tr><td>Permit Type has no requirements</td></tr>
             @else
               @foreach($checklist as $row)
                  <tr id="{{ $row->id }}"><td>{{ $row->name }}</td><td><input type="checkbox" class="checklist_status" name="status" data-id="{{ $row->id }}" @if($row->status == 1): {{ 'checked' }} @endif></td><td><a class="delete-req"><i class="fa fa-close"></i></a></td></tr>
               @endforeach
              @endif
             </tbody>
        </table>
        <a class="btn btn-primary add-checklist pull-right"><i class="fa fa-plus"></i> Add Requirement</a>

    </div>
    </div>
  </div>
</div>
<!-- /.tab-pane -->
@section('customjs')
<script type="text/javascript">
  
  
  $(function(){



    function isEmptyOrSpaces(str){
        return str === null || str.match(/^ *$/) !== null;
    }
    //Date picker
    $('#date_filed').datepicker({
      autoclose: true
    });
    $('[data-mask]').inputmask();

    $(document).on('change', '.checklist_status', function(e){
      e.preventDefault();
      var id = $(e.target).data('id');
      var status = 0;
      if (!this.checked){
        status = 0;
      }else{
        status = 1;
      }

      var jqxhr = $.ajax({
        method: "POST",
        url: "{{ url('/api/checklist/update/') }}/"+id,
        data : { 
          'status' : status,
          'user_id' : {{ Auth::user()->id }}
        },
      })
      .done(function(data){
        $.notify({icon: 'fa fa-info', message: data.message},{type: 'info', timer: 500});
      })
    })

    $('.add-checklist').on('click', function(e){
      e.preventDefault();
      var table = $('#requirements-tbl');
      table.prepend('<tr><td><input type="text" class="form-control req-name"></td><td><a class="btn btn-primary save-req"> <i class="fa fa-save"></i></a></td><td><a class="btn btn-warning cancel-req"><i class="fa fa-close"></i></a></td></tr>');
    });

    $(document).on('click', '.cancel-req', function(e){
      e.preventDefault();
      var row = $(this).parent().parent(); 
      row.remove();
    });
    $(document).on('click', '.save-req', function(e){
      e.preventDefault();
      var name = $(this).closest("tr").find("input.req-name").val();
      var element = $(this).parent().parent();
      var table = $('#requirements-tbl');
      if(isEmptyOrSpaces(name)){
        alert("Requirement name is empty")
      }else{
        var jqxhr = $.ajax({
          method: "POST",
          url: "{{ url('/api/checklist/add/') }}",
          data : { 'name' : name, 'id': '{{ $masterlist->id }}', 'api_token' : '{{ Auth::user()->api_token }}' },
        })
        .done(function(data){
          if(data.type == 'success'){
            $.notify({icon: 'fa fa-info', message: data.message},{type: 'info', timer: 500});
            element.remove();
            var isCheck =  '';
            if(data.status == 1){
              isCheck = 'checked';
            }
            table.prepend('<tr id="'+data.id+'"><td>'+data.name+'</td><td><input type="checkbox" class="checklist_status" name="status" data-id="'+data.id+'" '+isCheck+'></td><td><a class="delete-req"><i class="fa fa-close"></i></a></td></tr>');
          }else{
            $.notify({icon: 'fa fa-warning', message: data.message},{type: 'danger', timer: 500});
          }
          
        })
      }
    });

    $(document).on('click', '.delete-req', function(e){
      e.preventDefault()
      var row = $(this).parent().parent();
      var id = row.attr('id');
      var jqxhr = $.ajax({
          method: "POST",
          url: "{{ url('/api/checklist/delete/') }}/"+id
        })
        .done(function(data){
          $.notify({icon: 'fa fa-warning', message: data.message},{type: 'danger', timer: 500});
          row.remove();
        });
    });
  });
</script>
@endsection