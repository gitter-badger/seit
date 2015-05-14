<header class="main-header">
    <!-- Logo -->
    <a href="{!! URL::action('DashboardController@getIndex') !!}" class="logo"><b>SeIT</b> | Eve Industry</a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="{!! URL::action('DashboardController@getIndex') !!}" class="dropdown-toggle" data-placement="bottom" data-toggle="tooltip" title="" data-original-title="Queued Jobs">
                        <i class="fa fa-tasks"></i>
                        <span id="count_queued" class="label label-info">0</span>
                    </a>
                </li>
                <li class="dropdown tasks-menu">
                    <a href="{!! URL::action('DashboardController@getIndex') !!}" class="dropdown-toggle" data-placement="bottom" data-toggle="tooltip" title="" data-original-title="Done Jobs">
                        <i class="fa fa-tasks"></i>
                        <span id="count_done" class="label label-success">0</span>
                    </a>
                </li>
                <li class="dropdown tasks-menu">
                    <a href="{!! URL::action('DashboardController@getIndex') !!}" class="dropdown-toggle" data-placement="bottom" data-toggle="tooltip" title="" data-original-title="Working Jobs">
                        <i class="fa fa-tasks"></i>
                        <span id="count_working" class="label label-warning">0</span>
                    </a>
                </li>
                <li class="dropdown tasks-menu">
                    <a href="{!! URL::action('DashboardController@getIndex') !!}" class="dropdown-toggle" data-placement="bottom" data-toggle="tooltip" title="" data-original-title="Errored Jobs">
                        <i class="fa fa-tasks"></i>
                        <span id="count_error" class="label label-danger">0</span>
                    </a>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{!! 'https://secure.gravatar.com/avatar/' . md5( strtolower( trim( \Auth::user()->email ) ) ) . '?d=mm' !!}" class="user-image" alt="User Image"/>
                        <span class="hidden-xs">{!! \Auth::user()->name !!}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{!! 'https://secure.gravatar.com/avatar/' . md5( strtolower( trim( \Auth::user()->email ) ) ) . '?d=mm' !!}" class="img-circle" alt="User Image" />
                            <p>
                                {!! \Auth::user()->name !!}
                                <small>{!! \Auth::user()->email !!}</small>
                                <small>Member since {!! \Auth::user()->created_at !!}</small>
                            </p>
                        </li>
                        {{--
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>
                        --}}
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{!! URL::action('ProfileController@getIndex') !!}" class="btn btn-default btn-flat"><span class="fa fa-user"></span> Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{!! URL::action('Auth\AuthController@getLogout') !!}" class="btn btn-default btn-flat"> <span class="fa fa-power-off"></span> Sign out </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
