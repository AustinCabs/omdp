
<div class="active tab-pane" id="permit">
  <div class="box"> 
    <div class="box-header">
      <h3 class="box-title">Business Data</h3>
    </div>
    <div class="box-body">
      <div class="form-group">
        <div class="col-md-6">
          <label class="control-label">Date filed :</label>
           <input id="date_filed" type="text" class="form-control" name="date_filed" value="{{ $masterlist->date_filed }}" placeholder="Date filed">
        </div>
        <div class="col-md-6">
          <label class="control-label">Tin No. :</label>
          <input type="number" class="form-control" name="tin_no" placeholder="Tin Number" value="{{ $masterlist->tin_no }}">
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-6">
          <label class="control-label">Contact No. :</label>
          <input class="form-control" name="contact_no" data-inputmask='"mask": "0999-999-9999"' data-mask value="{{ $masterlist->contact_no }}" placeholder="Contact No">
        </div>
        <div class="col-md-6">
          <label class="control-label">Type :</label>
          <select name="type" class="form-control">
            @foreach ($types as $row)
              <option value="{{ $row->id }}" @if($masterlist->type == $row->id) {{'selected'}} @endif>{{ $row->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-6">
          <label class="control-label">Total Area (square mtrs) :</label>
          <input class="form-control" type="number" name="area_volume" value="{{ $masterlist->area_volume }}" placeholder="Total Area"></input>
        </div>
      </div>

      <div class="col-md-6">
          <div class="form-group">
            <label class="control-label">Longhitude :</label>
            <input class="form-control" name="longhitude" value="{{ $masterlist->longhitude }}">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label">Latitude :</label>
            <input class="form-control" name="latitude" value="{{ $masterlist->latitude }}">
          </div>
        </div>
    </div>
  </div>
</div>
<!-- /.tab-pane -->
@section('customjs')
<script type="text/javascript">
  
  $(function(){
    //Date picker
    $('#date_filed').datepicker({
      autoclose: true
    });
    $('[data-mask]').inputmask();


  })
</script>
@endsection