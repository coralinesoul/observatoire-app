<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('fav.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <nav class="bg-white p-4 mx-8">
        <div class="w-full px-8 flex items-center justify-between">
            <!-- Logo -->
            <div class="w-60 h-auto pr-8">
                <a href="{{ route('home') }}">
                  <img src="{{ asset('Logo.png') }}" alt="Logo" class="object-contain w-full h-auto">
                </a>
            </div>
    
            <!-- Menu de Navigation -->
            <div class="hidden md:flex space-x-4 items-center">
                <a 
                    class="text-blue2 font-medium text-lg hover:bg-gray-100 px-3 py-2 rounded {{ request()->routeIs('catalogue.index') ? 'text-blue1 font-bold' : '' }}" 
                    aria-current="page" 
                    href="{{ route('catalogue.index') }}"
                >
                    Le catalogue
                </a>
                <a 
                    class="text-blue2 font-medium text-lg hover:bg-gray-100 px-3 py-2 rounded {{ request()->routeIs('home') ? 'text-blue1 font-bold' : '' }}" 
                    href="{{ route('home') }}"
                >
                    L'observatoire
                </a>
                <a 
                class="text-blue2 font-medium text-lg hover:bg-gray-100 px-3 py-2 rounded {{ request()->routeIs('home') ? 'text-blue1 font-bold' : '' }}" 
                href="{{ route('about') }}"
            >
                A propos
            </a>
            </div>
            
    
            <!-- Actions d'authentification -->
            <div class="hidden md:flex items-center space-x-4 ml-auto">
                @auth
                    <a href="{{ route('catalogue.user_tab') }}" class=" text-blue2 hover:bg-gray-100 px-3 py-2 rounded"> {{ \Illuminate\Support\Facades\Auth::user()->name }} </a>
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
    <div class="w-full px-8">
        @if (session('success'))
            <div class="rounded-md text-green-700 bg-green-100 border border-green-300 p-2">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <livewire:cookie-banner />
    <div class="w-full min-h-96 px-8">
        @yield('content')
    </div>
</body>
<footer class="bg-blue2 mt-6" aria-labelledby="footer-heading">
    <h2 id="footer-heading" class="sr-only">Footer</h2>
    <div class="mx-auto max-w-7xl px-6 pb-8 pt-16 sm:pt-24 lg:px-8 lg:pt-32">
      <div class="xl:grid xl:grid-cols-2 xl:gap-8">
        <div class="space-y-8">
          <a href="https://www.institut-ecocitoyen.fr/pres.php" target="_blank">
            <img class="h-40" src="{{ asset('Logo_institut_blanc.png') }}" alt="Institut écocitoyen">
          </a>
          <div class="flex space-x-6">
            <a href="https://www.facebook.com/institutecocitoyen" class="text-white hover:text-gray-200">
              <span class="sr-only">Facebook</span>
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
              </svg>
            </a>
            <a href="https://www.instagram.com/institut_ecocitoyen/" class="text-white hover:text-gray-200">
                <span class="sr-only">Instagram</span>
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill-rule="evenodd" d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.333 3.608 1.308.975.975 1.246 2.242 1.308 3.608.058 1.266.07 1.646.07 4.851s-.012 3.585-.07 4.851c-.062 1.366-.333 2.633-1.308 3.608-.975.975-2.242 1.246-3.608 1.308-1.266.058-1.646.07-4.851.07s-3.585-.012-4.851-.07c-1.366-.062-2.633-.333-3.608-1.308-.975-.975-1.246-2.242-1.308-3.608C2.175 15.584 2.163 15.204 2.163 12s.012-3.585.07-4.851c.062-1.366.333-2.633 1.308-3.608.975-.975 2.242-1.246 3.608-1.308C8.415 2.175 8.795 2.163 12 2.163zm0-1.658C8.757.505 8.336.52 7.046.573 5.677.631 4.304.919 3.312 1.912 2.319 2.905 2.031 4.278 1.973 5.647.92 7.94.918 8.763.918 12s.002 4.06.055 5.647c.058 1.369.347 2.742 1.34 3.735.993.993 2.366 1.282 3.735 1.34 1.588.053 2.41.055 5.647.055s4.06-.002 5.647-.055c1.369-.058 2.742-.347 3.735-1.34.993-.993 1.282-2.366 1.34-3.735.053-1.588.055-2.41.055-5.647s-.002-4.06-.055-5.647c-.058-1.369-.347-2.742-1.34-3.735-.993-.993-2.366-1.282-3.735-1.34C15.664.52 15.243.505 12 .505zm0 5.838a6.674 6.674 0 100 13.349 6.674 6.674 0 000-13.349zm0 11.065a4.39 4.39 0 110-8.78 4.39 4.39 0 010 8.78zm6.406-11.65a1.567 1.567 0 11-3.135 0 1.567 1.567 0 013.135 0z" clip-rule="evenodd"/>
                </svg>
            </a>
            <a href="https://www.linkedin.com/company/institut-ecocitoyen/posts/?feedView=all" class="text-white hover:text-gray-200">
                <span class="sr-only">LinkedIn</span>
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill-rule="evenodd" d="M22.23 0H1.77C.792 0 0 .774 0 1.727v20.546C0 23.227.792 24 1.77 24h20.46C23.208 24 24 23.227 24 22.273V1.727C24 .774 23.208 0 22.23 0zM7.12 20.452H3.56V9h3.56v11.452zM5.34 7.603a2.065 2.065 0 110-4.13 2.065 2.065 0 010 4.13zm15.112 12.849h-3.562v-5.631c0-1.343-.025-3.073-1.872-3.073-1.872 0-2.16 1.462-2.16 2.97v5.734H9.3V9h3.418v1.561h.048c.475-.9 1.635-1.848 3.366-1.848 3.598 0 4.263 2.367 4.263 5.445v6.294z" clip-rule="evenodd"/>
                </svg>
            </a>            
          </div>
        </div>
          <div class="md:grid md:grid-cols-2 md:gap-8 p-6 justify-self-end">
            <div>
              <h3 class="text-sm font-semibold leading-6 text-white">Catalogue</h3>
              <ul role="list" class="mt-6 space-y-4">
                <li>
                  <a href="/catalogue" class="text-sm leading-6 text-white hover:text-gray-200">Recherche</a>
                </li>
                <li>
                  <a href="/catalogue/mes-etudes" class="text-sm leading-6 text-white hover:text-gray-200">Ajout d'une étude</a>
                </li>
                <li>
                  <a href="/demande" class="text-sm leading-6 text-white hover:text-gray-200">Demande de compte</a>
                </li>
              </ul>
            </div>
            <div class="mt-10 md:mt-0">
              <h3 class="text-sm font-semibold leading-6 text-white">Informations</h3>
              <ul role="list" class="mt-6 space-y-4">
                <li>
                  <a href="/a-propos" class="text-sm leading-6 text-white hover:text-gray-200">Contact</a>
                </li>
                <li>
                  <a href="/" class="text-sm leading-6 text-white hover:text-gray-200">L'observatoire</a>
                </li>
                <li>
                  <a href="https://www.institut-ecocitoyen.fr/pres.php" class="text-sm leading-6 text-white hover:text-gray-200">L'institut</a>
                </li>
              </ul>
            </div>
          </div>
      </div>
      <div class="mt-16 border-t border-white/50 pt-8 sm:mt-20 lg:mt-24">
        <p class="text-xs leading-5 text-white">&copy; 2024 Institut écocitoyen pour la connaissance des pollutions. Tout droit réservés.</p>
      </div>
    </div>
  </footer>
</html>
