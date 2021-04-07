
<div class="active tab-pane" id="permit">
  <div class="box"> 
    <div class="box-header">
      <h3 class="box-title">Business Data</h3>
    </div>
    <div class="box-body">
      <div class="form-group">
        <div class="col-md-6">
          <label class="control-label">Date filed :</label>
           <input id="date_filed" type="text" class="form-control" name="date_filed" value="{{ old('date_filed') }}" placeholder="Date filed">
        </div>
        <div class="col-md-6">
          <label class="control-label">Tin No. :</label>
          <input type="number" class="form-control" name="tin_no" placeholder="Tin Number" value="{{ old("tin_no", $masterlist->tin_no) }}">
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-6">
          <label class="control-label">Contact No. :</label>
          <input class="form-control" name="contact_no" data-inputmask='"mask": "0999-999-9999"' data-mask value="{{ old('contact_no', $masterlist->contact_no) }}" placeholder="Contact No">
        </div>
        <div class="col-md-6">
          <label class="control-label">Type :</label>
          <select name="type" class="form-control">
            @foreach ($types as $row)
              <option value="{{ $row->id }}" {{ (old('type', $masterlist->type) == $row->id ? "selected":"") }}>{{ $row->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-6">
          <label class="control-label">Total Area (square mtrs) :</label>
          <input class="form-control" type="number" name="area_volume" value="{{ old('area_volume', $masterlist->area_volume) }}" placeholder="Total Area"></input>
        </div>
      </div>
      <div class="col-md-6"></div>
      <div class="col-md-6">
          <div class="form-group">
            <label class="control-label">Longhitude :</label>
            <input class="form-control" name="longhitude" value="{{ old('longhitude', $masterlist->longhitude) }}" placeholder="Longhitude">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label">Latitude :</label>
            <input class="form-control" name="latitude" value="{{ old('latitude', $masterlist->latitude) }}" placeholder="Latitude">
          </div>
        </div>
    </div>
  </div>

  <div class="box with-border">
    <div class="box-header">
      <h3 class="box-title"> <i class="fa fa-check-square"></i> Requirements</h3>
    </div>
    <div class="box-body">
      <div class="content table-responsive table-full-width">
        <table class="table table-hover table-bordered" id="requirements-tbl">
             <tbody>
                <tr><td>Select Permit Type</td></tr>
             </tbody>
        </table>
    </div>
    </div>
  </div>
</div>
<!-- /.tab-pane -->
@section('customjs')
<script type="text/javascript">
  
  $(function(){
    $(document).ready(function(){
      var id = $('#permit_type').val();
        $("#requirements-tbl tr").remove()
        if(id == 0){
          $('#requirements-tbl').append('<tr><td>Select Permit Type</td></tr>');
        }else{
          var jqxhr = $.ajax({
            method: "GET",
            url: "{{ url('/api/permit_type_checklist') }}/"+id
          })
          .done(function(data){
            var len = data.length
            console.log(data)
            if( len == 0){
              $('#requirements-tbl').append('<tr><td>Permit Type has no requirements. </td></tr>');
            }else{
              for (var i = 0; len != i; i++) {

                $('#requirements-tbl').append('<tr id="'+data[i].id+'"><td>'+ data[i].name +'</td></tr>');
              }
            }
            
          })
        }
    })
    
      

    $('#date_filed').datepicker({
      autoclose: true
    });
    $('[data-mask]').inputmask();

    $('#permit_type').change(function(e){
      e.preventDefault()
      var id = $('#permit_type').val();
      $("#requirements-tbl tr").remove()
      if(id == 0){
        $('#requirements-tbl').append('<tr><td>Select Permit Type</td></tr>');
      }else{
        var jqxhr = $.ajax({
          method: "GET",
          url: "{{ url('/api/permit_type_checklist') }}/"+id
        })
        .done(function(data){
          var len = data.length
          console.log(data)
          if( len == 0){
            $('#requirements-tbl').append('<tr><td>Permit Type has no requirements. </td></tr>');
          }else{
            for (var i = 0; len != i; i++) {

              $('#requirements-tbl').append('<tr id="'+data[i].id+'"><td>'+ data[i].name +'</td></tr>');
            }
          }
          
        })
      }
        
    })
  })
</script>
@endsection