<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                   @if (Auth::user()->gender == 0 )
                        <img src="{{ asset('img/avatar04.png') }}" class="img-circle" alt="User Image"/>
                    @else
                        <img src="{{ asset('img/avatar2.png') }}" class="img-circle" alt="User Image"/>
                    @endif
                </div>
                <div class="pull-left info">
                    <p style="overflow: hidden;text-overflow: ellipsis;max-width: 160px;" data-toggle="tooltip" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Main Menu</li>
            @if (Auth::user()->role != 1)
                 <!-- Optionally, you can add icons to the links -->
                <li {{ (Request::is('home*') ? 'class=active' : '') }}><a href="{{ url('home') }}"><i class='fa fa-dashboard'></i> <span>Dashboard</span></a></li>
                <li {{ (Request::is('masterlist*') ? 'class=active' : '') }}><a href="{{ url('masterlist') }}"><i class='fa fa-list'></i> <span>Masterlist</span></a></li>
            @endif

            <li {{ (Request::is('billing*') ? 'class=active' : '') }}><a href="{{ url('billing') }}"><i class='fa fa-money'></i> <span>Billing</span></a></li>

            @if (Auth::user()->role != 1)
                <li {{ (Request::is('chats*') ? 'class=active' : '') }}><a href="{{ url('chats') }}"><i class='fa fa-envelope'></i> <span>Messages</span></a></li>
                <li {{ (Request::is('reports*') ? 'class=active' : '') }}><a href="{{ url('reports') }}"><i class='fa fa-pie-chart'></i> <span>Reports</span></a></li>
                
            @endif

            @if (Auth::user()->role == 2 || Auth::user()->role == 3)
                <li class="{{ (Request::is('settings*') ? 'active' : '') }} treeview">
                  <a href="#">
                    <i class="fa fa-gear"></i> <span>Settings</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu {{ (Request::is('settings*') ? 'menu-open' : '') }}">
                    <li {{ (Request::is('settings/users*') ? 'class=active' : '') }}><a href="{{ url('settings/users') }}"><i class="fa fa-users"></i> User Management</a></li>
                    <li {{ (Request::is('settings/data*') ? 'class=active' : '') }}><a href="{{ url('settings/data') }}"><i class="fa fa-gears"></i> Predefined Data</a></li>
                    <li {{ (Request::is('settings/announcement*') ? 'class=active' : '') }}><a href="{{ url('settings/announcement') }}"><i class="fa fa-volume-up"></i> Announcements</a></li>
                  </ul>
                </li>
            @endif
            
            
        </ul><!-- /.sidebar-menu -->
        @else
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">Main Menu</li>
                 <li class="active"><a href="#"><i class='fa fa-user'></i> <span>My Data</span></a></li>
                
                
            </ul>
        @endif

    </section>
    <!-- /.sidebar -->
</aside>
