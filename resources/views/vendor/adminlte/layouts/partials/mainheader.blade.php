<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    @guest
        <a href="{{ url('/') }}" class="logo">
    @else
        @if (Auth::user()->role == 1)
            <a href="{{ url('/billing') }}" class="logo">
        @else
             <a href="{{ url('/home') }}" class="logo">
        @endif
    @endguest
        <span class="logo-lg pull-left">
            <img src="{{ asset('img/logo/south-cot.png')}}" class="img-circle" style="max-width:45px; position: relative;" alt="logo">
        </span>
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>OM</b>P</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Open Mining</b> Portal </span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @guest
                    <li><a href="{{ url('/') }}"><i class="fa fa-arrow-left"></i> Exit</a></li>
                    
                @else
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <ul class="dropdown-menu">
                            <li class="header">{{ trans('adminlte_lang::message.tabmessages') }}</li>
                            <li>
                                <!-- inner menu: contains the messages -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <!-- User Image -->
                                                @if (Auth::user()->gender == 0 )
                                                    <img src="{{ asset('img/avatar04.png') }}" class="img-circle" alt="User Image"/>
                                                @else
                                                    <img src="{{ asset('img/avatar2.png') }}" class="img-circle" alt="User Image"/>
                                                @endif
                                            </div>
                                            <!-- Message title and timestamp -->
                                            <h4>
                                                {{ trans('adminlte_lang::message.supteam') }}
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <!-- The message -->
                                            <p>{{ trans('adminlte_lang::message.awesometheme') }}</p>
                                        </a>
                                    </li><!-- end message -->
                                </ul><!-- /.menu -->
                            </li>
                            <li class="footer"><a href="#">c</a></li>
                        </ul>
                    </li><!-- /.messages-menu -->
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            @if (Auth::user()->gender == 0 )
                                <img src="{{ asset('img/avatar04.png') }}" class="user-image" alt="User Image"/>
                            @else
                                <img src="{{ asset('img/avatar2.png') }}" class="user-image" alt="User Image"/>
                            @endif
                            
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                @if (Auth::user()->gender == 0 )
                                    <img src="{{ asset('img/avatar04.png') }}" class="img-circle" alt="User Image"/>
                                @else
                                    <img src="{{ asset('img/avatar2.png') }}" class="img-circle" alt="User Image"/>
                                @endif
                                <p>
                                    {{ Auth::user()->name }}
                                </p>
                                
                               
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ url('/profile').'/'.Auth::user()->id }}" class="btn btn-default btn-flat">{{ trans('adminlte_lang::message.profile') }}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ trans('adminlte_lang::message.signout') }}
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="submit" value="logout" style="display: none;">
                                    </form>

                                </div>
                            </li>
                        </ul>
                    </li>
                @endguest
                
            </ul>
        </div>
    </nav>
</header>
