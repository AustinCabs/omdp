@extends('adminlte::layouts.app')

@section('htmlheader_title', "Permittee's Profile")
@section('contentheader_title', "Permittee's Profile")
@section('module', 'Masterlist')
@section('level', 'Application')

@section('main-content')
   
    <div class="row">
      
      <form enctype="multipart/form-data">
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
              <img class="img-responsive pad" src="{{ asset('/field_images').'/'.$masterlist->img }}" alt="Photo">
              <h3 class="profile-username text-center">{{ $masterlist->business_name }}</h3>
                <p class="text-muted text-center">{{ $masterlist->owner_name }}</p>
              

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Address</b>
                </li>
               <p>{{ $masterlist->prk.' '.$masterlist->brgy.', '.$masterlist->municipality.' '.$masterlist->province.' '.$masterlist->island}}</p>
               <li class="list-group-item">
                  <b>Permit Type</b>
                </li>
               <p>{{ App\Permittype::where('id', $masterlist->permittype_id)->first()->name }}</p>
                @if ($masterlist->status == 1)
                  <li class="list-group-item">
                    <b>Expiration</b>
                  </li>
                  <p>{{ date("M d, Y", strtotime( $masterlist->expiry_date)) }}</p>
                @endif
                <li class="list-group-item">
                  <b>Application Type</b>
                </li>
               <p>
                @if ($masterlist->application_type == 0)
                    New
                @else
                    Renewal
                @endif
               </p>
                <li class="list-group-item">
                  <b>Query Code</b>
                </li>
                <p>{{ $masterlist->query_code }}</p>
              </ul>
             
              @if (Auth::user()->role == 2 || Auth::user()->role == 3)
                <a href="{{ url('masterlist/updateGet').'/'.$masterlist->id }}" class="btn btn-primary btn-block"><i class="fa fa-edit"></i> <b>Update</b></a>
              @endif
              @if($masterlist->status == 1 && strtotime(date('Y-m-d')) > strtotime($masterlist->expiry_date))
                <a class="btn btn-primary btn-block" @if ($billings != $paid) onclick="checkBill()" @else  href="{{ url('/masterlist/renewGet/').'/'.$masterlist->id }}"  @endif><i class="fa fa-reply"></i> <b>Renewal</b></a>
              @elseif($masterlist->status == 1)
                <a href="{{ url('/printPermit')."/".$masterlist->id }}" class="btn btn-primary btn-block"><i class="fa fa-print"></i> <b>Print Permit</b></a>
              @endif
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-8">
          <div class="box box-primary box-solid collapsed-box">
              <div class="box-header with-border">
                <h3 class="box-title">Permit Details</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                  </button>
                </div>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body" style="">
                <div class="nav-tabs-custom">
                 @if (Auth::user()->role == 2 || Auth::user()->role == 3)
                     <a class="btn btn-sm btn-info pull-right" data-toggle="modal" data-target="#changeStatus" @if ($billings != $paid || $masterlist->status == 1 && strtotime(date('Y-m-d')) > strtotime($masterlist->expiry_date))
                       disabled
                     @endif> <i class="fa fa-gears"></i> Change Status 
                    @if ($masterlist->status == 0)
                      {{ '(pending)'}}
                    @elseif ($masterlist->status == 1)
                      {{ '(approved)'}}
                    @else
                      {{ '(declined)' }}
                    @endif
                  @endif
                   
                  </a>
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#permit" data-toggle="tab"> <i class="fa fa-wpforms"></i> Other Details & Requirements</a></li>
                  <li><a href="#activity" data-toggle="tab"> <i class="fa fa-globe"></i> Activity Logs</a></li>
                  <li><a href="#location" data-toggle="tab"> <i class="fa fa-map"></i> Location</a></li>
                </ul>
                <div class="tab-content">
                  
                  @include('adminlte::masterlist.partials.permits-update')

                  @include('adminlte::masterlist.partials.activity')
                  @include('adminlte::masterlist.partials.location')
                </div>
              </div>
            </div>
          </div>
          @if ($masterlist->status == 1)
            <div class="box box-primary box-solid collapsed-box">
              <div class="box-header with-border">
                <h3 class="box-title">Sales and Production Reports</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                  </button>
                </div>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                @include('adminlte::masterlist.partials.reports')
              </div>
              <!-- /.box-body -->
            </div>
            <div class="box box-primary box-solid collapsed-box">
              <div class="box-header with-border">
                <h3 class="box-title">Penalties</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                  </button>
                </div>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                @include('adminlte::masterlist.partials.penalty')
              </div>
            </div>
          </div>
          @endif
          
        </div>
        <!-- /.col -->
      </form>
    </div>
      <!-- /.row -->
      <script type="text/javascript">
        
        function checkBill(){
          $.notify({icon: 'fa fa-info', message: 'Permit has a pending bill'},{type: 'warning', timer: 500});
        }
      </script>

@include('adminlte::masterlist.modals.change_status')
@endsection
