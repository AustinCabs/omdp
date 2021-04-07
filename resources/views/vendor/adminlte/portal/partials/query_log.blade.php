<!DOCTYPE html>
<html>
@include('adminlte::layouts.partials.htmlheader')
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  @if (count($errors) > 0)
      <div class="alert alert-danger">
          <strong>Whoops!</strong> {{ trans('adminlte_lang::message.someproblems') }}<br><br>
          <ul>
              @foreach ($errors as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif
  <div class="lockscreen-logo">
     <a href="{{ url('/') }}"><b>Open Mining </b>Portal</a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name">Permit Query</div>
  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
        <img src="{{ asset('img/logo/south-cot.png')}}" class="img-circle" style="max-width:150px; position: relative;" alt="logo">
    </div>
    <!-- /.lockscreen-image -->
        
    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials" action="{{ url('/query/find') }}" method="GET" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="input-group">
        <input type="text" class="form-control" name="query_code" placeholder="Query Code">

        <div class="input-group-btn">
          <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="lockscreen-footer text-center">
    Copyright &copy; 2019  <a href="https://web.facebook.com/PEMOSoCot/?_rdc=1&_rdr">Provincial Environment Management Office</a>
  </div>
</div>
<!-- /.center -->

<!-- jQuery 3 -->
@include('adminlte::layouts.partials.scripts')
</body>
</html>
