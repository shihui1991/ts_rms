<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
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

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>

    @php
           dump(encrypt(123));
    dump(decrypt('eyJpdiI6Imx6YkwyNlVRbTJJZmxZQ1kwMVY4d2c9PSIsInZhbHVlIjoieVR3cTJ2ZFwvMEEyUnFnS3JkK1dta3c9PSIsIm1hYyI6ImYyOTUyMDhiNmRiZGEyODI5ZTgwOTg1MjhjZDM5NmRkZTAxZDk1MjYwMWJlMTE1YTZmYmQ3NGZjMjM0NTNhNjkifQ=='));

            @endphp
    <hr>
    eyJpdiI6IkFaQzlMZDBXdXJCcmphWDZYdVhoT0E9PSIsInZhbHVlIjoiTjN0T0pPMitsYXlyS1NPMVcrQlVTdz09IiwibWFjIjoiMWJmMTU2MzRjYjBmNjAwYzk0YWY3Y2E3ZmZiYWE2ZDA5ZjlmNGE3N2YzOWRlMjYxY2Y3MDk2NThjOTc4NzE3MiJ9
    eyJpdiI6IkV2NElsSnYzQ1N5d0UrU01SQjVFR2c9PSIsInZhbHVlIjoiMGwyaWhhWXVEcnVhRVpDWlFCOWZCZz09IiwibWFjIjoiYzBhMGNmMzNiMDg4OGNkZDBmMmRiZGFkZDVlMDAxM2RiNWFjNjc1ZDFjZGEzYjEyNzRjODNiYmE4NDY1YzM5MSJ9
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>
