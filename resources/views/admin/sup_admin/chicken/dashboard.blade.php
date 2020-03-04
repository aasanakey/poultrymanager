@extends('admin.sup_admin.dashboard')
@section('profile')
<a class="dropdown-item" href="{{route('admin.profile')}}">Profile</a>
    {{-- <a class="dropdown-item" href="#">Activity Log</a> --}}
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('admin.logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fa fa-logout"></i>logout</a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
@endsection

@section('sidenav-links')
    {{-- <div class="sb-sidenav-menu-heading">Livestock Manager</div> --}}
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
        <div class="sb-nav-link-icon"><i class="fas fa-crow"></i></div>
        Birds
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="{{route('admin.bird.population','chicken')}}">Population</a>
            <a class="nav-link" href="layout-sidenav-light.html">Mortality</a>
        </nav>
    </div>
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
        <div class="sb-nav-link-icon"><i class="fas fa-egg"></i></div>
        Eggs
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                Production
            </a>
        </nav>
    </div>
    {{-- <div class="sb-sidenav-menu-heading">Addons</div> --}}
    <a class="nav-link collapse" href="#" data-toggle="collapse" data-target="#collapseFeed" aria-expanded="false" aria-controls="collapseFeed">
        <div class="sb-nav-link-icon"><i class="fas fa-cookie-bite"></i></div>
        Feed
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseFeed" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                Stock
            </a>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
               Feeding
            </a>
        </nav>
    </div>
    <a class="nav-link collapse" href="#" data-toggle="collapse" data-target="#collapseMed" aria-expanded="false" aria-controls="collapseMed">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
        Medication and Vaccination
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseMed" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
               Medication
            </a>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                Vaccination
            </a>
        </nav>
    </div>

@endsection
