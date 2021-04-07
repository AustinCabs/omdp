@extends('adminlte::layouts.app')

@section('htmlheader_title', "Data Settings")
@section('contentheader_title', "Data Settings")
@section('module', 'Settings')
@section('level', 'Data')

@section('main-content')
   
<div class="row">
  @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
  <div class="col-md-3">
    {{-- <a {{ (Request::is('mailbox') ? 'href='.url('compose') : 'href='.url('mailbox')) }} class="btn btn-primary btn-block margin-bottom" style="margin-bottom: 20px">
    @if (Request::is('mailbox'))
      <i class="fa fa-edit"></i>
    @else
      <i class="fa fa-repeat"></i> 
    @endif
    {{ (Request::is('mailbox') ? ' Compose' : 'Back to Mailbox') }}</a>
    --}}
    <div class="box box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Menu</h3>

        <div class="box-tools">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
        <li {{ (Request::is('settings/data') ? 'class=active' : '') }}><a href="{{ url('settings/data') }}"><i class="fa fa-money"></i> Billing </a></li>
          <li {{ (Request::is('settings/data/checklist*') ? 'class=active' : '') }}><a href="{{ url('settings/data/checklist') }}"><i class="fa fa-file-text-o"></i> Checklist</span></a></li>
        </ul>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div> 
  <!-- /.col -->
  <div class="col-md-9">
    @if(Request::is('settings/data'))
      @include('adminlte::settings.data-settings.partials.billing')
    @elseif(Request::is('settings/data/checklist'))
      @include('adminlte::settings.data-settings.partials.checklist')
    @endif
  </div>
  <!-- /.col -->
</div>
      


@endsection
