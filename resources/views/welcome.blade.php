<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
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
        <link media="all" type="text/css" rel="stylesheet" href="/assets/css/main.css">
    </head>
    <body>
        <div class="flex-center position-ref full-height top-header">
            <div class="content header-text">
                <div class="title m-b-md header-title-text">
                    <p class="header-text">
                        <a href="/">
                            <img src="/assets/images/brand-icon.png" alt="brand-icon">
                            <span>&nbsp;FUN!
                        <span class="title-country">&nbsp;Japan Indonesia</span>
                    </span>
                        </a>
                    </p>
                </div>

                <div class="links">
                    <a href="{{ url('id') }}">Indonesia</a>
                    <a href="{{ url('ms') }}">Malaysia</a>
                    <a href="{{ url('th') }}">Thailand</a>
                    <a href="{{ url('tw') }}">Taiwan</a>
                </div>
            </div>
        </div>
    </body>
</html>
