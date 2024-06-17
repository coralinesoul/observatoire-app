<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{ mix('resources/css/app.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('LOGO.png') }}" width="100%" height="80" class="d-inline-block align-text-top">
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('catalogue.index') }}">Le catalogue</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Les études</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">A propos</a>
                    </li>
                </ul>
                <div class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @auth
                        {{ \Illuminate\Support\Facades\Auth::user()->name }}
                        <form action="{{ route('auth.logout') }}" method="post">
                            @method("delete")
                            @csrf
                            <button class="nav-link">Se déconnecter</button>
                        </form>
                    @endauth
                    @guest
                        <a href="{{ route('auth.login') }}">Se connecter</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
    <div>
        <svg width="1207" height="6" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 3H1204" stroke="#A6CFCE" stroke-width="6" stroke-linecap="round"/>
        </svg>
    </div>
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
