<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            /* .title {
                font-size: 84px;
            } */

            .links > a {
                color:#fff;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 900;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .logo{
                text-align:center;
            }
            .logo h1{
                font-family: 'Montserrat', sans-serif;
                font-size: 3em;
                color: #000;
                display: inline-block;
                position:relative;
            }
            .logo h1 a{
                text-decoration:none;
                color: #fff;
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
                font-weight: bold;
                padding: 3px;
                display: inline-block;
                position: absolute;
                top: 9px;
                left: -14px;
                color: #000;
                line-height: 8px;
            }
            div.full-height{
                background-image: url('/images/pic5.jpg');
            }
            div.full-height::before{
                content:'';
                position: absolute;
                left: 0;
                top: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0,0,0,.5);
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                   @include('layouts.logo')
                </div>

                <div class="links">
                    {{-- <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a> --}}
                </div>
            </div>
        </div>
    </body>
</html>
