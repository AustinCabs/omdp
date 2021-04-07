@extends('adminlte::layouts.app')

@section('htmlheader_title', 'Permit Application Registration')
@section('contentheader_title', 'Permit Application Registration')
@section('module', 'Masterlist')
@section('level', 'Application')

@section('main-content')
    <div class="row">
      
      <form action="{{url('masterlist/addPost') }}" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
        <div class="col-md-4">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <input type="hidden" name="application_type" value="{{ $application_type }}">
              <h3 class="profile-username">Site Photo : <input class="form-control" type="file" name="img" accept="image/*" value="{{ old('img') }}"></h3>
              <h3 class="profile-username">Business Name : <input class="form-control" name="business_name" placeholder="Business Name" value="{{ old('business_name', $masterlist->business_name) }}"></h3>

              <p class="text-muted">Owner's Name : <input class="form-control" name="owner_name" placeholder="Owner's Name" value="{{ old('owner_name', $masterlist->owner_name) }}"></input></p>

              <p class="text-muted">Permit No. : <input class="form-control" name="permit_no" placeholder="Permit No." value="{{ old('permit_no') }}"></input></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Address</b>
                  
                </li>
                <p><input class="form-control" name="prk" placeholder="Purok/Sitio" value="{{ old('prk', $masterlist->prk) }}"></p>
                <p><input class="form-control" name="brgy" placeholder="Barangay" value="{{ old('brgy', $masterlist->brgy) }}"></p>
                <p><input class="form-control" name="municipality" placeholder="City/Municipality" value="{{ old('municipality', $masterlist->municipality) }}"></p>
              </ul>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Permit Type</b>
                </li>
                <select class="form-control" name="permit_type" id="permit_type">
                  <option value="0" selected>Select</option>
                  @foreach($permit_types as $row)
                    <option value="{{ $row->id }}" {{ (old('type', $masterlist->permittype_id) == $row->id ? "selected":"") }}>{{ $row->name }}</option>
                  @endforeach
                </select>
              </ul>

              <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> <b>Save</b></button>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-8">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#permit" data-toggle="tab"> <i class="fa fa-wpforms"></i> Other Details & Requirements</a></li>
            </ul>
            <div class="tab-content">
              
             @include('adminlte::masterlist.partials.permits')
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </form>
    </div>
      <!-- /.row -->


@endsection
@section('customjs')
<script type="text/javascript">
  $(function(){
    $('#masterlist').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
  });
</script>
@endsection
