<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'The Poultry Farm') }}</title>
        <link href="{{asset('css/app.css')}}" rel="stylesheet" />
        <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
        {{-- <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" /> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            .footer-bottom{
                text-align:center;
            }
            .footer-bottom h2 {
                font-family: 'Montserrat', sans-serif;
                font-size: 3.5em;
                display: inline-block;
                position:relative;
            }
            .footer-bottom h2 a {
                text-decoration: none;
                color: #000;
            }
            .footer-bottom h2 span {
                font-size: 12px;
                display: block;
                letter-spacing: 5px;
                text-transform: uppercase;
                font-family: 'Noto Sans', sans-serif;
                padding-top: 6px;
            }
            .footer-bottom h2 b {
                font-size: 10px;
                background: #CC2127;
                font-weight: normal;
                padding: 3px;
                display: inline-block;
                line-height: 10px;
                position: absolute;
                top: 9px;
                left: -7px;
            }
        </style>
        @yield('styles')
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="##">{{ \App\Farm::find(auth()->user()->farm_id)->farm_name}}</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
            ><!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                {{-- <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div> --}}
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        @yield('profile')
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                @yield('sidenav')
            </div>
            <div id="layoutSidenav_content">
                <main>
                  <div class="container-fluid">
                      @yield('content')
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="footer-bottom">
                             <img src="{{asset('/images/logo.png')}}" alt="logo" >
                            <p class="fo-para"></p>
                        </div>
                        <hr/>
                        <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; The Poultry Farm</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <script src="{{asset('js/app.js')}}"></script>
        <script src="{{asset('js/scripts.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        @yield('script-tags')
       <script>
           $(document).ready(()=>{
            @yield('script')
           });
       </script>
    </body>
</html>
