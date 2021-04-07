@extends('adminlte::layouts.app')

@section('htmlheader_title', "My Profile")
@section('contentheader_title', "My Profile")
@section('module', 'Query')
@section('level', 'My Data')

@section('main-content')
   
    <div class="row">
      
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
                <li class="list-group-item">
                  <b>Status</b>
                  <p>@if ($masterlist->status == 0)
                      {{ '(pending)'}}
                    @elseif ($masterlist->status == 1)
                      {{ '(approved)'}}
                    @else
                      {{ '(declined)' }}
                    @endif</p>
                </li>
                <li class="list-group-item">
                  <b>Remarks</b>
                  <p>
                    @if(empty($masterlist->remarks))
                      No remarks recorded.
                    @else
                      {{ strip_tags($masterlist->remarks) }}
                    @endif
                  </p>
                </li>
              </ul>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-8">
          <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Billing Status and Penalties</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                  <table class="table table-striped" id="penalties">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Description</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th>Type</th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach ($masterlist->billings as $row)
                        <tr id="penalty-{{$row->id}}">
                          <td>{{ $row->id }}</td>
                          <td>{{ $row->name }}</td>
                          <td>{{ number_format($row->fee, 2) }}</td>

                         
                              <td>
                              @if ($row->status == 0)
                                <span class="badge bg-red">Pending</span>
                              @else
                                <span class="badge bg-blue">Paid</span>
                              @endif
                              </td>
                              <td>
                                @if ($row->type == 0)
                                  <span class="badge bg-green">Permit fee</span>
                                @else
                                  <span class="badge bg-yellow">Penalty</span>
                                @endif
                              </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>

              </div>
            </div>
          </div>
        </div>
        <!-- /.col -->
    </div>
      <!-- /.row -->
      

@endsection
