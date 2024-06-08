<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .background-container {
            background-image: url('https://i.pinimg.com/564x/df/7a/26/df7a26b6f147928898004d71fa71293d.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            height: 100%;
        }

        h1 {
            text-align: center;
            color: #fff;
        }

        .btn-login {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50px;
            margin-top: 20px;
        }

        .btn-login a {
            background-color: #5EE1F1;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-login a:hover {
            background-color: #4cb5c4;
        }

        .footer-info {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
            color: #fff;
            font-weight: bold;
        }
    </style>
</head>

<body class="background-container">
    <h1>Welcome to Laravel Backend of Jasmy Ecommerce!</h1>
    <div class="btn-login">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" style="margin-left: 10px;">Register</a>
                @endif
            @endauth
        @endif
    </div>
    <div class="footer-info">
        </h2>
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        <h2 class="">
    </div>
</body>

</html>
