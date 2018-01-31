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
           dump(encrypt('1RERE'));
    dump(decrypt('eyJpdiI6IitKVzVkTHE3SnhTSHpyTTRqTXdDWGc9PSIsInZhbHVlIjoiRDBDMWlKRTJrOUo1REdwYTFOWE5tZz09IiwibWFjIjoiOWRjODM0NDFlM2U5MDk4ZDRmMjllMTg3MDRlMWQ5Y2FkMDYwYTlmZTNjNDBiNTQzMGUzOWVmYWJhZmJjMDRhYyJ9'));

            @endphp
    <hr>
    eyJpdiI6ImtWb3FIWURnU04ycGlXc1lDSUFnR0E9PSIsInZhbHVlIjoiQ3RERk5SaDNiSnN6YzVQeis0NVBnZz09IiwibWFjIjoiZTlhMzViMjUyMDk3ZjhhZDMzODViOGI3ZTQ5NDU1NWE1YTcxMmMzMDA4NzM0ZTc5Y2ZkM2RmMzNiZDVmNGI0NiJ9
    eyJpdiI6ImJoTGR0WTVYZG9BODhySjI3eFNCZlE9PSIsInZhbHVlIjoiZEp0T0w3dGk1cUVWa0ZudU9GbWRjZFlGQ1BVQTBcL2w2SmE0S2YyZ1QrcWc9IiwibWFjIjoiNmQwYTJiZGI4ZjdjYjQwNmUxZTA2MDgwMDc2N2FkNTg1NjAxMTc2YmIzZjBkYWMyNGNlMjJkYmFkMDg2OGM0YiJ9
    eyJpdiI6ImI0d01iXC9kSzI2MnRiRnZmNHpNNU1nPT0iLCJ2YWx1ZSI6IjhSczc0NXZPR25kaWppTkxDSk8ycWUxOGx2cTFxZUZwblFTRnc2ZW9mbGc9IiwibWFjIjoiNmMwNWI2OTVkYWE1OWQ2MmM3MTA2NGQwNTRjYjBjZDk4ZWZkN2RmNzVhZjIwODhlZTViNWI1ZGEyNjIxNGMzYSJ9
    eyJpdiI6Ik1hS09oVlROMmEzd01BYWl3QitoRmc9PSIsInZhbHVlIjoicTdRcDBNRVVpc0xPanc0VG1lVnJ3MXJMWjR1amhHRHhJWmMxNUx2OFE1Zz0iLCJtYWMiOiJmMDQ3MjliOWNlZDg1MjViYTg0OTkxNTE0NDU0YmQyNTRmMzE5MzUyODU2OTQwOWU3N2U3MGY2ZTYyYmE5MTRlIn0=
    eyJpdiI6IjV3clVMWWRDS0IwWURqWjhcL1R1OVFBPT0iLCJ2YWx1ZSI6Ikpyem5cL0p1UmpZOXFEcGFSMkUzVEtnPT0iLCJtYWMiOiIwYjQyMzhmNjQzNWNiNDcxNjE4NDYwMzliNDQ4MzhiOWQ4OGZlMjRiODY3ZDgxZmEwYzA5MjA1MTZmNDIxZjNlIn0=
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
