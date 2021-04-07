@extends('adminlte::layouts.app')

@section('htmlheader_title', 'My Profile')
@section('contentheader_title', 'My Profile')
@section('module', 'My Profile')
@section('level', 'Settings')
@section('main-content')
<div class="row">
  <div class="col-md-12">

    <!-- Profile Image -->
    <div class="box box-primary">
      <div class="box-body box-profile">
        @if (Auth::user()->gender == 0 )
            <img src="{{ asset('img/avatar04.png') }}" class="profile-user-img img-responsive img-circle" alt="User Image"/>
        @else
            <img src="{{ asset('img/avatar2.png') }}" class="profile-user-img img-responsive img-circle" alt="User Image"/>
        @endif

        <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

        <p class="text-muted text-center">
          @if (Auth::user()->role == 0 )
            Encoder
          @elseif (Auth::user()->role == 1 )
            Billing
          @elseif (Auth::user()->role == 2 )
            GeoSciences Admin
          @elseif (Auth::user()->role == 3 )
            Superuser
          @endif
        </p>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->

    
    <!-- /.box -->
  </div>
  <!-- /.col -->
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">
        <form action="{{ url('/updateProfile').'/'.Auth::user()->id }}" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
          <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Name</label>

            <div class="col-sm-10">
              <input type="text" class="form-control" name="name" value="{{Auth::user()->name }}" id="inputName" placeholder="Name">
            </div>
          </div>
          <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label">Email</label>

            <div class="col-sm-10">
              <input type="email" name="email" class="form-control" id="inputEmail" value="{{ Auth::user()->email }}" placeholder="Email">
            </div>
          </div>
          <div class="form-group">
            <label for="inputExperience" class="col-sm-2 control-label">Gender</label>

            <div class="col-sm-10">
              <select name="gender" class="form-control">
                @if (Auth::user()->gender == 0)
                  <option value="0" selected>Male</option>
                  <option value="1">Female</option>
                @else
                  <option value="0">Male</option>
                  <option value="1" selected>Female</option>
                @endif
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <a data-toggle="modal" data-target="#changepass">Change Password</a>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-danger">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /.col -->
</div>
@include('adminlte::auth.modals.change_pass')
@endsection