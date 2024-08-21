<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    </head>
<body>
    <nav class="bg-white p-4 mx-8">
        <div class="w-full px-8 flex items-center justify-between">
            <!-- Logo -->
            <div class="w-48 h-auto pr-8">
                <img src="{{ asset('Logo.png') }}" alt="Logo" class="object-contain w-full h-auto">
            </div>
    
            <!-- Menu de Navigation -->
            <div class="hidden md:flex space-x-4 items-center">
                <a 
                    class="text-blue2 font-medium text-lg hover:bg-gray-100 px-3 py-2 rounded {{ request()->routeIs('catalogue.index') ? 'text-blue1 font-bold' : '' }}" 
                    aria-current="page" 
                    href="{{ route('catalogue.index') }}"
                >
                    Catalogue
                </a>
                <a 
                    class="text-blue2 font-medium text-lg hover:bg-gray-100 px-3 py-2 rounded {{ request()->routeIs('catalogue.about') ? 'text-blue1 font-bold' : '' }}" 
                    href="{{ route('catalogue.about') }}"
                >
                    A propos
                </a>
            </div>
            
    
            <!-- Actions d'authentification -->
            <div class="hidden md:flex items-center space-x-4 ml-auto">
                @auth
                    <span class="text-blue2 hover:bg-gray-100 px-3 py-2 rounded"> {{ \Illuminate\Support\Facades\Auth::user()->name }} </span>
                    <form action="{{ route('auth.logout') }}" method="post">
                        @method("delete")
                        @csrf
                        <button type="submit" class="text-blue2 font-medium text-lg hover:bg-gray-100 px-3 py-2 rounded"> Se déconnecter</button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('auth.login') }}" class="text-blue2 hover:bg-gray-100 px-3 py-2 rounded"> Se connecter</a>
                @endguest
            </div>

    </nav>
    <div class="w-full px-8">
        <hr class="border-blue2 border-t-4 rounded">
    </div>
    <br>
    <div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="w-full px-8">
        @yield('content')
    </div>
</body>
</html>
