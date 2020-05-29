@extends('layouts.dashboard')


{{-- @section('profile')
<a class="dropdown-item" href="{{route('admin.profile')}}">Profile</a>
    {{-- <a class="dropdown-item" href="#">Activity Log</a> -}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('admin.logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fa fa-logout"></i>logout</a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
@endsection --}}

@section('sidenav')
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="@yield('side_dash_link')"
                    ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard</a
                >
                @yield('sidenav-links')
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ auth()->user()->role}}
        </div>
    </nav>
@endsection
 @section('content')
        @yield('dash_content')
@endsection
