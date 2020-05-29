@extends('admin.dashboard')
@section('side_dash_link')
    {{route('admin.home','chicken')}}
@endsection
@section('profile')
<a class="dropdown-item" href="{{route('admin.profile','chicken')}}">Profile</a>
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
            <a class="nav-link" href="{{ route('admin.bird.mortality','chicken')}}">Mortality</a>
            <a class="nav-link" href="{{ route('admin.bird.pen','chicken')}}">House</a>
        </nav>
    </div>
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
        <div class="sb-nav-link-icon"><i class="fas fa-egg"></i></div>
        Eggs
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav" >
            <a class="nav-link" href="{{route('admin.egg.production','chicken')}}">Production</a>
        </nav>
    </div>
    {{-- <div class="sb-sidenav-menu-heading">Addons</div> --}}
    <a class="nav-link collapse" href="#" data-toggle="collapse" data-target="#collapseFeed" aria-expanded="false" aria-controls="collapseFeed">
        <div class="sb-nav-link-icon"><i class="fas fa-cookie-bite"></i></div>
        Feed
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseFeed" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link collapsed" href="{{route('admin.feed.stock','chicken')}}">Stock</a>
            <a class="nav-link collapsed" href="{{route('admin.feeding.record','chicken')}}">Feeding</a>
        </nav>
    </div>
    <a class="nav-link collapse" href="#" data-toggle="collapse" data-target="#collapseMed" aria-expanded="false" aria-controls="collapseMed">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
        Medication and Vaccination
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseMed" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link collapsed" href="{{route('admin.medicine','chicken')}}">
               Medication
            </a>
            <a class="nav-link collapsed" href="{{route('admin.vaccine','chicken')}}">
                Vaccination
            </a>
        </nav>
    </div>
    <a class="nav-link collapse" href="#" data-toggle="collapse" data-target="#collapseSale" aria-expanded="false" aria-controls="collapseSale">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
            Sales
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseSale" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link collapsed" href="{{route('admin.sale.bird','chicken')}}">
                Bird Sale
            </a>
            <a class="nav-link collapsed" href="{{route('admin.sale.egg','chicken')}}">
                Egg Sale
            </a>
            <a class="nav-link collapsed" href="{{route('admin.sale.meat','chicken')}}">
                Meat Sale
            </a>
        </nav>
    </div>
    <a class="nav-link collapse" href="#" data-toggle="collapse" data-target="#collapseLogicstic" aria-expanded="false" aria-controls="collapseLogicstic">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
            Logistic
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseLogicstic" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link collapsed" href="{{route('admin.farm.equipment','chicken')}}">
               Equipment
            </a>

            {{-- <a class="nav-link collapsed" href="{{route('admin.sale.meat','chicken')}}">
                Meat Sale
            </a> --}}
        </nav>
    </div>
     @if (auth()->user()->hasRole('SUPER_ADMIN'))
       <a class="nav-link collapse" href="#" data-toggle="collapse" data-target="#collapseAdmin" aria-expanded="false" aria-controls="collapseAdmin">
            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Staff
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseAdmin" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link collapsed" href="{{route('admin.employee','chicken')}}">
                    Employees
                </a>
                <a class="nav-link collapsed" href="{{route('admin.users','chicken')}}">
                    Users
                </a>
            </nav>
        </div>
    @endif


@endsection
