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
  <script src="{{asset('/portal/lib/jquery/jquery.min.js') }}"></script>
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/portal/css/chat.css') }}">
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>

  <!-- Main Stylesheet File -->
  <link href="{{asset('/portal/css/style.css')}}" rel="stylesheet">

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
        <h1><a href="#body" class="scrollto"><span>OpenMining</span> Portal</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="#body"><img src="img/logo.png" alt="" title="" /></a>-->
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a id="home" href="#hero" class="tabbers">Home</a></li>
          <li><a id="directory" href="#listing" class="tabbers">Public Directory</a></li>
          <li class="menu-has-children"><a>Announcements</a>
            <ul>
             @foreach ($announcements as $row)
               <li>{{ $row->name }} <small>{{ date("M d Y", strtotime( $row->date)) }}</small></li>
             @endforeach
            </ul>
          </li>
          <li><a href="{{ url('login') }}">Login</a></li>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <!--==========================
    Hero Section
  ============================-->
  <section id="hero" class="wow fadeIn">
    <div class="hero-container">
      <h2>Welcome to Open Mining Portal.</h2>
      <img src="{{asset('/portal/img/hero-img.png')}}" alt="Hero Imgs">
      <a href="{{ url('/query/login') }}" class="btn-get-started scrollto">Permit Query</a>
    </div>
  </section>
  <section id="listing" class="padd-section text-center wow fadeInUp">

    <div class="container">
      <div class="section-title text-center">

        <h2>Permitee Public Directory</h2>

      </div>
      <div class="card">
        <div class="card-header">
          
        </div>
        <div class="card-body">
          <table id="master" class="table">
            <thead>
              <tr>
                <th>Permit No.</th>
                <th>Expiry</th>
                <th>Location</th>
                <th>Type</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
               @foreach($masterlist as $row)
                <tr>
                  <td> <a href="{{url('/permitee/').'/'.$row->id}}"> {{ $row->permit_no }}</a></td>
                  <td>@if(!empty($row->expiry_date)) {{ date("M d Y", strtotime( $row->expiry_date)) }} @else {{ 'N/A' }} @endif </td>
                  <td>{{ $row->prk.' '.$row->brgy.', '.$row->municipality.' '.$row->province.', '.$row->island }}</td>
                  <td>{{ App\Permittype::getDetails($row->permittype_id)->name }}</td>
                  <td>
                    @if($row->status == 0)
                      Pending
                    @elseif($row->status == 1)
                      Approved
                    @else
                      Denied
                    @endif

                  </td>
                </tr>
                @endforeach
            </tbody>
            {{$masterlist->links()}}
          </table>
        </div>
      </div>
    </div>

  </section>
  <div>
    <div id="chat" class="chat_window form-popup">
      <div class="top_menu">
        <div class="buttons">
          <div class="close closer">x</div>
        </div>
        <div class="title">Chat</div>
      </div>
        <ul class="messages"></ul>
      <div class="bottom_wrapper clearfix">
        <div class="row">
          <div class="col-md-4">
              <div class="form-group">
                <input class="form-control message_number" data-mask data-inputmask='"mask": "09999999999"' placeholder="Contact no." style="height: 100%;
            box-sizing: border-box;
            width: 100%;
            position: absolute;
            outline-width: 0;
            color: gray;" />
              </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <input class="form-control message_text" placeholder="Type your message here..." style="border: border-box;
            height: 100%;
            box-sizing: border-box;
            width: 100%;
            position: absolute;
            outline-width: 0;
            color: gray;" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="send_message">
              <div class="icon"></div>
              <div class="text">Send</div>
            </div>
          </div>
        </div> 
      </div>
    </div>
    <div class="message_template">
      <li class="message">
        <div class="avatar"></div>
        <div class="text_wrapper">
          <div class="text"></div>
        </div>
      </li>
    </div>

    <button type="button" class="btn btn-info btn-sm open-button" style="display:inline;">Direct Message</button>
  </div>
  <footer class="footer">
    <div class="container">
      <div class="row">

        <div class="col-md-12 col-lg-4">
          <div class="footer-logo">

            <a class="navbar-brand" href="{{url('/')}}">OpenMining Portal</a>
            <p>&copy; {{ date('Y') }}</p>

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

<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
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

    $('#master').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false,
      'pageLength':10
    });
    $('.open-button').on('click', function(e){
      e.preventDefault();

      var check = $('#chat').css('display');
      if(check == "block"){
        $('#chat').hide('slow');
      }else{
        $('#chat').show('slow');
      }
    })
    $('.closer').on('click', function(e){
      e.preventDefault()
      $('#chat').hide('slow')
    })
    $('[data-mask]').inputmask();
  });
  $(function () {
        var Message, sendApi;
        Message = function (arg) {
            this.text = arg.text, this.message_side = arg.message_side;
            this.draw = function (_this) {
                return function () {
                    var $message;
                    $message = $($('.message_template').clone().html());
                    $message.addClass(_this.message_side).find('.text').html(_this.text);
                    $('.messages').append($message);
                    return setTimeout(function () {
                        return $message.addClass('appeared');
                    }, 0);
                };
            }(this);
            return this;
        };
        $(function () {
            var contact = $('message_number').val()
            var getMessageText, message_side, sendMessage;
            message_side = 'left';
            getMessageText = function () {
                var $message_input;
                $message_input = $('.message_text');
                return $message_input.val();
            };
            sendMessage = function (text, side) {
                var contact = $('.message_number').val();
                message_side = side;
                if(side == 'right'){
                  $.ajax({
                    method: "POST",
                    url: "{{ url('/api/sendMessage') }}",
                    data : {
                      'message':text,
                      'contact':contact
                    }
                  }).done(function(data){
                    console.log(data)
                  })
                }
                if(contact.toString().length != 11 && side == 'right'){
                  alert('Please fill contact details')
                }else{
                   var $messages, message;
                  if (text.trim() === '') {
                      return;
                  }
                  $('.message_text').val('');
                  $messages = $('.messages');
                  message = new Message({
                      text: text,
                      message_side: message_side
                  });
                  message.draw();
                  return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
                }
               
            };
            $('.send_message').click(function (e) {
                return sendMessage(getMessageText(), 'right');
            });
            $('.message_text').keyup(function (e) {
                if (e.which === 13) {
                    return sendMessage(getMessageText(), 'right');
                }
            });
            sendMessage('This is a direct message to PEMO admin officer. Please feel free to send your concerns. Thank You!', 'left')

        });
    }.call(this));
</script>

</body>
</html>
