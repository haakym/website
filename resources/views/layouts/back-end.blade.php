<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <title>AdminLTE 2 | Blank Page</title>
   
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="{{ asset('assets/css/AdminLTE.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/_all-skins.css') }}">

        {{-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries --}}
        {{-- WARNING: Respond.js doesn't work if you view the page via file:// --}}
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
<body class="hold-transition skin-blue sidebar-mini">
    {{-- Site wrapper --}}
    <div class="wrapper">

        <header class="main-header">
            {{-- Logo --}}
            <a href="../../index2.html" class="logo">
                {{-- mini logo for sidebar mini 50x50 pixels --}}
                <span class="logo-mini"><b>A</b>LT</span>
                {{-- logo for regular state and mobile devices --}}
                <span class="logo-lg"><b>Admin</b>LTE</span>
            </a>
            {{-- Header Navbar: style can be found in header.less --}}
            <nav class="navbar navbar-static-top">
                {{-- Sidebar toggle button--}}
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        {{-- Notifications: style can be found in dropdown.less --}}
                        <li class="notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-warning">10</span>
                            </a>
                        </li>
                        
                        {{-- User Account: style can be found in dropdown.less --}}
                        <li class="user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="https://placehold.it/160x160" class="user-image" alt="User Image">
                                <span class="hidden-xs">Alexander Pierce</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        {{-- =============================================== --}}
        {{-- Left side column. contains the sidebar --}}
        <aside class="main-sidebar">
            {{-- sidebar: style can be found in sidebar.less --}}
            <section class="sidebar">
                {{-- Sidebar user panel --}}
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="https://placehold.it/160x160" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>Alexander Pierce</p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                {{-- search form --}}
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
                {{-- /.search form --}}
                {{-- sidebar menu: : style can be found in sidebar.less --}}
                <ul class="sidebar-menu">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-home"></i> <span>Verhuur</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="#"><i class="fa fa-circle-o"></i> Verhuur overzicht</a></li>
                            <li><a href="#"><i class="fa fa-circle-o"></i> Verhuur toevoegen</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}">
                            <i class="fa fa-group"></i>
                            <span>Login beheer</span>
                        </a>
                    </li>
                </ul>
            </section>
            {{-- /.sidebar --}}
        </aside>

        {{-- =============================================== --}}
        {{-- Content Wrapper. Contains page content --}}
        <div class="content-wrapper">
            {{-- Content Header (Page header) --}}
            <section class="content-header">
                @yield('content-header')
            </section>

            {{-- Main content --}}
            <section class="content">

                {{-- Default box --}}
                    @yield('content')
                {{-- /.box --}}

            </section>
            {{-- /.content --}}
        </div>
        {{-- /.content-wrapper --}}

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.3.6
            </div>
            <strong>Copyright &copy; 2014-{{ date('Y')}} </strong>Tim Joosten.  Alle rechten voorbehouden.
        </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/fastclick.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
