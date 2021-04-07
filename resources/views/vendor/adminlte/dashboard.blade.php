@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection
@section('module', 'Dashboard')
@section('level', 'Summary')
@section('contentheader_title', 'Dashboard')


@section('main-content')
	  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3>
            {{ count(App\Masterlist::where('status', 0)->get()) }}
          </h3>

          <p>New Applicants</p>
        </div>
        <div class="icon">
          <i class="fa fa-user-plus"></i>
        </div>
        
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>
            @if(count(App\Masterlist::all()) != 0 )
              {{ number_format((App\Masterlist::where('status', 1)->count()/App\Masterlist::count())*100, 2)  }}
            @else
              {{ '0' }}
            @endif
            <sup style="font-size: 20px">%</sup>
          </h3>

          <p>Approved Rate</p>
        </div>
        <div class="icon">
          <i class="fa fa-bar-chart"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3> {{ count(App\User::all()) }}</h3>

          <p>User Registrations</p>
        </div>
        <div class="icon">
          <i class="fa fa-users"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{ count(App\Masterlist::where('status', 2)->get()) }}</h3>

          <p>Declined Applicants</p>
        </div>
        <div class="icon">
          <i class="fa fa-pie-chart"></i>
        </div>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->
  <!-- Main row -->
  <div class="row">
    <section class="col-lg-12 connectedSortable">
       <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class="active"><a href="#data-chart" data-toggle="tab"> <i class="fa fa-send"></i></a></li>
              <li class="pull-left header"><i class="fa fa-inbox"></i> {{ date('Y') }} Mineral Product Graph</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane active" id="data-chart" style="height:300px;">
                <svg></svg>
              </div>
            </div>
          </div>
          <!-- /.nav-tabs-custom -->

        </section>
  </div>

@endsection
@section('customjs')
<script type="text/javascript">
  $(function(){

      var jqxhr = $.ajax({
        method: "get",
        url: "/api/getGraphData"
      })
      .done(function(obj){
        const monthNames = ["", "Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];
          var area = Morris.Bar({
              element: 'data-chart',
              data: [
                  {y: 1, a: obj.SAG[0], b: obj.ORE[0]},
                  {y: 2, a: obj.SAG[1], b: obj.ORE[1]},
                  {y: 3, a: obj.SAG[2], b: obj.ORE[2]},
                  {y: 4, a: obj.SAG[3], b: obj.ORE[3]},
                  {y: 5, a: obj.SAG[4], b: obj.ORE[4]},
                  {y: 6, a: obj.SAG[5], b: obj.ORE[5]},
                  {y: 7, a: obj.SAG[6], b: obj.ORE[6]},
                  {y: 8, a: obj.SAG[7], b: obj.ORE[7]},
                  {y: 9, a: obj.SAG[8], b: obj.ORE[8]},
                  {y: 10, a: obj.SAG[9], b: obj.ORE[9]},
                  {y: 11, a: obj.SAG[10], b: obj.ORE[10]},
                  {y: 12, a: obj.SAG[11], b: obj.ORE[11]}
              ],
              xkey: 'y',
              parseTime: false,
              ykeys: ['a','b'],
              xLabelFormat: function (x) {
                  var index = parseInt(x.src.y);
                  return monthNames[index];
              },
              xLabels: "month",
              labels: ['SAG', 'ORE'],
              lineColors: ['#3dbeee', '#3c8dbc'],
              hideHover: 'auto'

          });
      });
       
        // Fix for charts under tabs
      $('.box ul.nav a').on('shown.bs.tab', function () {
        area.redraw();
      });
  });
</script>
@endsection
