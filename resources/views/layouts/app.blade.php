<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="ERP for poultry farm managements system" />
        <meta name="author" content="Augustine Ayiku Sanakey" />
        <meta name=”robots” content=”index, follow”>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'The Poultry Farm') }}</title>
        <link rel="canonical" href="{{config('app.url')}}" />
        <link href="{{asset("/css/styles.css")}}" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            .-bg-primary{
                background-color:lightgreen;
            }
            /* #layoutAuthentication_content .card{
                background-image:url('/images/pic4.jpg');
            } */
            .logo{
                text-align:center;
                margin-top: 5vh;
            }
              .card-header{
                background-color:#000;
                color:white;
            }
            /* .logo h1{
                font-family: 'Montserrat', sans-serif;
                font-size: 3em;
                color: #000;
                display: inline-block;
                position:relative;
            }
            .logo h1 a{
                text-decoration:none;
                color: #000;
            }
            .logo h1 span {
                font-size: 12px;
                display: block;
                letter-spacing: 4px;
                text-transform: uppercase;
                font-family: 'Noto Sans', sans-serif;
                padding-top: 4px;
            }
            .logo h1  b {
                font-size: 8px;
                background: #ED0612;
                font-weight: normal;
                padding: 3px;
                display: inline-block;
                position: absolute;
                top: 8px;
                left: -2px;
                color: #fff;
                line-height: 8px;
                /* margin-right:10px !important; *
            }*/
            .footer-bottom{
                text-align:center;
            }
            /*.footer-bottom h2 {
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
                top: 12px;
                left: -11px;
            }

            @media (max-width: 460px) {
                .footer-bottom h2 b{
                   left: 11px;
                   top: 9px;
                }
                .footer-bottom h2{

                    font-size: 2.5em;
                }
             }
             @media (max-width: 400px) {
                .footer-bottom h2 b{
                   left: 0px;
                   top: 9px;
                }
                .footer-bottom h2{

                    font-size: 2.5em;
                }
             }

             @media (max-width: 380px) {
                .footer-bottom h2 b{
                   left: -10px;
                   top: 9px;
                }
                .footer-bottom h2{

                    font-size: 2.5em;
                }
             }
             @media (max-width: 354px) {
                .footer-bottom h2 b{
                    font-size: 5px;
                    line-height: 5px;
                   left: 10px;
                   top: 3px;
                }
                .footer-bottom h2{

                    font-size: 20px;
                }
                .footer-bottom h2 span{
                    font-size: 8px;
                }
             } */
        </style>
        @yield('styles')
    </head>
    <body class="-bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    @yield('content')
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="footer-bottom">
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
        {{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> --}}
        <script src="{{asset("/js/app.js")}}"></script>
        <script src="{{asset("/js/scripts.js")}}"></script>
        @yield('script-tags')
        <script>
            $(document).ready(()=>{
                @yield('script')
            });
        </script>
    </body>
</html>
