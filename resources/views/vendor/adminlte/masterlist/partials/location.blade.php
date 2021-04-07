@section('extra-heads')
  <script type="text/javascript">var centreGot = false;</script>
{!! $map['js'] !!}
@endsection
<div class="tab-pane" id="location">
   <div class="box"> 
    <div class="box-header">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label">Longhitude :</label>
            <input class="form-control" name="longhitude" value="{{ $masterlist->longhitude }}" disabled>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label">Latitude :</label>
            <input class="form-control" name="latitude" value="{{ $masterlist->latitude }}" disabled>
          </div>
        </div>
      </div>
    </div>
    <div class="box-body">
      {!! $map['html'] !!}
    </div>
  </div>     
</div>
              