<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Google Tag Manager -->
   <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-N9JRF6DD');</script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    @vite('resources/css/app.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="description" content="@yield("meta_description", "Découvrez l'obseratoire du golfe de Fos et ses actions.")">
    <link rel="icon" href="{{ asset('fav.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N9JRF6DD"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
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
      <div class="grid grid-cols-2 xl:gap-8">
        <div class="space-y-8">
          <a href="https://www.institut-ecocitoyen.fr/pres.php" target="_blank">
            <img class="h-40" src="{{ asset('Logo_institut_blanc.png') }}" alt="Institut écocitoyen">
          </a>
          <div class="flex space-x-6">
            <a href="https://www.facebook.com/institutecocitoyen" class="text-white hover:text-gray-200">
              <span class="sr-only">Facebook</span>
              <i class="fa-brands fa-facebook text-3xl"></i>
            </a>
            <a href="https://www.instagram.com/institut_ecocitoyen/" class="text-white hover:text-gray-200">
                <span class="sr-only">Instagram</span>
                <i class="fa-brands fa-instagram text-3xl"></i>
            </a>
            <a href="https://www.linkedin.com/company/institut-ecocitoyen/posts/?feedView=all" class="text-white hover:text-gray-200">
                <span class="sr-only">LinkedIn</span>
                <i class="fa-brands fa-linkedin text-3xl"></i>
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
