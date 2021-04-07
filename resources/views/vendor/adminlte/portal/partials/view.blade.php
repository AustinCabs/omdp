<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Open Mining Portal</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="{{ asset('img/logo/south-cot.png')}}" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Roboto:100,300,400,500,700|Philosopher:400,400i,700,700i" rel="stylesheet">

  <!-- Bootstrap css -->
  <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
  <link href="{{asset('/portal/lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

  <!-- Libraries CSS Files -->
  
  <link href="{{asset('/portal/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
  <link href="{{asset('/portal/lib/owlcarousel/assets/owl.theme.default.min.css')}}" rel="stylesheet">
  <link href="{{asset('/portal/lib/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{asset('/portal/lib/animate/animate.min.css')}}" rel="stylesheet">
  <link href="{{asset('/portal/lib/modal-video/css/modal-video.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables/dataTables.bootstrap.css')}}">

  <script src="{{asset('/portal/lib/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>

  <!-- Main Stylesheet File -->
  <link href="{{asset('/portal/css/style.css')}}" rel="stylesheet">
  <script type="text/javascript">var centreGot = false;</script>
{!! $map['js'] !!}

  <!-- =======================================================
    Theme Name: eStartup
    Theme URL: https://bootstrapmade.com/estartup-bootstrap-landing-page-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->
</head>

<body>

  <header id="header" class="header header-hide">
    <div class="container">

      <div id="logo" class="pull-left">
        <h1><a href="{{ url('/')}}" class="scrollto"><span>OpenMining</span> Portal</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="#body"><img src="img/logo.png" alt="" title="" /></a>-->
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="{{ url('/') }}">Back</a></li>
          
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->
  
 <section id="pricing" class="padd-section text-center wow fadeInUp">

    <div class="container">
      <div class="section-title text-center">
      <h1>Public Directory</h1>

      </div>
    </div>

    <div class="container">
      <div class="row">

        <div class="col-md-6 col-lg-3">
          <div class="block-pricing">
            <div class="table with-border">
              <h4 class="business_name">{{ App\Permittype::getDetails($masterlist->permittype_id)->name }}</h4>
              <h2 class="permit_type">{{ $masterlist->permit_no }}</h2>
              <ul class="list-unstyled">
                <li class="address">{{ $masterlist->prk.' '.$masterlist->brgy.', '.$masterlist->municipality.' '.$masterlist->province.', '.$masterlist->island }}</li>
                <li class="status">
                  @if($masterlist->status == 0)
                    Pending
                  @elseif($masterlist->status == 1)
                    Approved
                  @else
                    Denied
                  @endif
                </li>
                @if ($masterlist->status == 1)
                  <li class="expirtion">
                    Expiration : {{ date("M d, Y", strtotime( $masterlist->expiry_date)) }}
                  </li>
                @endif
              </ul>
            </div>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-9">
          <div class="block-pricing">
            {!! $map['html'] !!}
          </div>
        </div>
      </div>
    </div>
    
  </section>
  <section class="padd-section text-center wow fadeInUp">
    <div class="container">
        <div class="section-title text-center">
          <h4>Production Data as of {{ date('Y') }}</h4>

      </div>
       <div class="row">
        <div class="col-md-12 col-lg-12">
          <div class="block-pricing">
            <table id="prod" class="table">
              <thead>
                <tr>
                  <th>Materials</th>
                  <th>{{  date("M Y", strtotime( date('Y').'-01')) }}</th>
                  <th>{{  date("M Y", strtotime( date('Y').'-02')) }}</th>
                  <th>{{  date("M Y", strtotime( date('Y').'-03')) }}</th>
                  <th>{{  date("M Y", strtotime( date('Y').'-04')) }}</th>
                  <th>{{  date("M Y", strtotime( date('Y').'-05')) }}</th>
                  <th>{{  date("M Y", strtotime( date('Y').'-06')) }}</th>
                  <th>{{  date("M Y", strtotime( date('Y').'-07')) }}</th>
                  <th>{{  date("M Y", strtotime( date('Y').'-08')) }}</th>
                  <th>{{  date("M Y", strtotime( date('Y').'-09')) }}</th>
                  <th>{{  date("M Y", strtotime( date('Y').'-10')) }}</th>
                  <th>{{  date("M Y", strtotime( date('Y').'-11')) }}</th>
                  <th>{{  date("M Y", strtotime( date('Y').'-12')) }}</th>
                </tr>
                
              </thead>
              <tbody>
                @foreach ($prod_data as $row)
                  <tr>
                    <td>{{ $row['name'] }}</td>
                    <td>{{ $row['data'][0] }}</td>
                    <td>{{ $row['data'][1] }}</td>
                    <td>{{ $row['data'][2] }}</td>
                    <td>{{ $row['data'][3] }}</td>
                    <td>{{ $row['data'][4] }}</td>
                    <td>{{ $row['data'][5] }}</td>
                    <td>{{ $row['data'][6] }}</td>
                    <td>{{ $row['data'][7] }}</td>
                    <td>{{ $row['data'][8] }}</td>
                    <td>{{ $row['data'][9] }}</td>
                    <td>{{ $row['data'][10] }}</td>
                    <td>{{ $row['data'][11] }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <div class="row">

        <div class="col-md-12 col-lg-4">
          <div class="footer-logo">

            <a class="navbar-brand" href="{{url('/')}}">OpenMining Portal</a>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the.</p>

          </div>
        </div>
      </div>
    </div>

    <div class="copyrights">
      <div class="container">
        <p>&copy; Copyrights Provincial Environment Management Office. All rights reserved.</p>
        <div class="credits">
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=eStartup
          -->
          Created by <a href="https://github.com/Psalms23">Jay Donguines</a>
        </div>
      </div>
    </div>

  </footer>



  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="{{asset('/portal/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('/portal/lib/superfish/hoverIntent.js')}}"></script>
  <script src="{{asset('/portal/lib/superfish/superfish.min.js')}}"></script>
  <script src="{{asset('/portal/lib/easing/easing.min.js')}}"></script>
  <script src="{{asset('/portal/lib/modal-video/js/modal-video.js')}}"></script>
  <script src="{{asset('/portal/lib/owlcarousel/owl.carousel.min.js')}}"></script>
  <script src="{{asset('/portal/lib/wow/wow.min.js')}}"></script>
  <!-- Contact Form JavaScript File -->
  <script src="{{asset('/portal/contactform/contactform.js')}}"></script>

  <!-- Template Main Javascript File -->
  <script src="{{asset('/portal/js/main.js')}}"></script>
  <script type="text/javascript">
  $(function(){
    var selected_tab = location.hash;
    $(selected_tab).trigger('click');

    $('a.tabbers').on('click', function(e){
      e.preventDefault();
      location.hash = e.target.id;
      console.log(location.hash, ' hash')
    })
    $('#prod').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false,
      'pageLength': 10
    });
  });
</script>

</body>
@include("adminlte::portal.modals.view")
</html>
