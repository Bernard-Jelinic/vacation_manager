@extends('layouts.app')

@section('content')

    <section id="container" >
        <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
        <!--header start-->
        <header class="header black-bg">
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <!--logo start-->
            <a href="{{ route('dashboard') }}" class="logo"><b>Vacation manager</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">
                    <!-- inbox dropdown start-->
                    <li id="header_inbox_bar" class="dropdown">
                        
                    </li>
                    <!-- inbox dropdown end -->
                </ul>
                <!--  notification end -->
            </div>
            <div class="top-menu">
                <ul class="nav pull-right top-menu">
                    <li>
                        <a class="logout" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </header>
        <!--header end-->
        
        <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
        <!--sidebar start-->
        <aside>
            <div id="sidebar"  class="nav-collapse ">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu" id="nav-accordion">
                    <p class="centered">
                        @if ( Auth::user()->image !== NULL )
                            <img src="{{ asset(Auth::user()->image) }}" class="img-circle" width="60">
                        @else
                            <img src=" {{ asset('assets/profilepictures/default.png') }} " class="img-circle" width="60">
                        @endif
                    </p>

                    <h5 class="centered">{{ ucfirst(Auth::user()->role) }}:</h5>
                    <h5 class="centered">{{ Auth::user()->name . ' ' . Auth::user()->last_name }}</h5>

                    <li class="sub-menu">
                        <a href="{{ route('dashboard') }}">
                            <i class="fa fa-home"></i>
                            <span>Home</span>
                        </a>
                    </li>

                    <li class="sub-menu">
                        <a href="{{ route('userprofile.edit', Auth::user()->id) }}">
                            <i class="fa fa-user"></i>
                            <span>User profile</span>
                        </a>
                    </li>
                    
                    @can('admin_area')
                    <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-th"></i>
                            <span>Departments</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{route('department.create')}}">Add Department</a></li>
                            <li><a href="{{route('department.index')}}">Manage Departments</a></li>
                        </ul>
                    </li>
                    @endcan

                    @can('admin_area')
                    <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-users"></i>
                            <span>Employees</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{route('user.create')}}">Add Employee</a></li>
                            <li><a href="{{route('user.index')}}">Manage Employee</a></li>
                        </ul>
                    </li>
                    @endcan
                    
                    <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-compass"></i>
                            <span>Vacations</span>
                        </a>

                        <ul class="sub">
                            @can('employee_area')
                            <li><a href="{{route('vacation.create')}}">Apply Vacation</a></li>
                            @endcan
                            <li><a href="{{route('vacation', 'all')}}">All Vacations</a></li>
                            <li><a href="{{route('vacation', 'pending')}}">Pending Vacations</a></li>
                            <li><a href="{{route('vacation', 'approved')}}">Approved Vacations</a></li>
                            <li><a href="{{route('vacation', 'notapproved')}}">Not Approved Vacations</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i>
                            <span>Logout</span>
                        </a>
                    </li>

                </ul>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->
        
        <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <div class="row">

                    {{-- <div id="notification-box" class="col-lg-3 ds" style="position: absolute; z-index: 100; right: 0px;">
                        <h3>NOTIFICATIONS</h3>
                        <a href="#">
                            <div class="desc">
                                <div class="details">
                                    <p style="font-size:12px;color:black;">Bernard Jelinić send request</p>
                                    <p style="font-size:12px;color:black;">created 2022-10-15</p>
                                </div>
                            </div>
                        </a>
                    </div> --}}

                    <div id="notification-box" style="position: absolute; z-index: 100; right: 0px;"></div>
        
                    @yield('dashboard')

                    @yield('userprofile.edit')

                    @yield('user.index')
                    @yield('user.create')
                    @yield('user.edit')

                    @yield('department.index')
                    @yield('department.create')
                    @yield('department.edit')

                    @yield('vacation')
                    @yield('vacation.create')
                    @yield('vacation.edit')
                
                </div>
            </section>
        </section>
    </section>

@endsection