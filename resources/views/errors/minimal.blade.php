<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('title')</title>
        {{-- <link href="{{ asset('css/app.css')}}" rel="stylesheet" /> --}}
        <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="layoutError">
            <div id="layoutError_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="text-center mt-4">
                                    <h1 class="display-1">@yield('code')</h1>
                                    <p class="lead"> @yield('message')</p>
                                    <p>@yield('extra_message')</p>
                                    <a href="{{ url()->previous()}}"><i class="fas fa-arrow-left mr-1"></i>Return to previous page</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutError_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div style="text-align:center">
                            <img src="{{asset('/images/logo.png')}}" alt="logo" >
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
        <script src="{{asset('/js/app.js')}}"></script>
        <script src="{{asset('js/scripts.js')}}"></script>
    </body>
</html>
