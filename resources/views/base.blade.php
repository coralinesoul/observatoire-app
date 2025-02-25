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
    <title>@yield('title') - Observatoire Golfe de Fos</title>
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
        <!-- Logo avec une taille minimale et marge à gauche -->
        <div class="w-72 h-auto pr-8 ml-4">
            <a href="{{ route('home') }}">
                <img src="{{ asset('Logo.png') }}" alt="Logo" class="object-contain w-full h-auto min-w-32">
            </a>
        </div>

        <!-- Menu de Navigation (version desktop) -->
        <div class="hidden lg:flex space-x-4 items-center justify-center">
            <a 
                class="text-blue2 font-medium text-lg hover:bg-gray-100 px-3 py-2 rounded {{ request()->routeIs('catalogue.index') ? 'text-blue1 font-bold' : '' }}" 
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
                class="text-blue2 font-medium text-lg hover:bg-gray-100 px-3 py-2 rounded {{ request()->routeIs('about') ? 'text-blue1 font-bold' : '' }}" 
                href="{{ route('about') }}"
            >
                A propos
            </a>
        </div>
        
        <!-- Actions d'authentification (version desktop) -->
        <div class="hidden lg:flex items-center space-x-4 ml-auto">
            @auth
                <a href="{{ route('catalogue.user_tab') }}" class="text-blue2 hover:bg-gray-100 px-3 py-2 rounded"> {{ \Illuminate\Support\Facades\Auth::user()->name }} </a>
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

        <!-- Bouton de menu mobile -->
        <div class="lg:hidden flex justify-between items-center">
            <button class="text-blue2 p-2" id="menu-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

    </div>

    <!-- Menu mobile (caché par défaut) -->
    <div class="hidden flex flex-col items-center space-y-4 mt-4" id="mobile-menu">
        <!-- Ligne 1 : Le catalogue -->
        <a 
            class="text-blue2 font-medium text-lg hover:bg-gray-100 px-3 py-2 rounded text-center {{ request()->routeIs('catalogue.index') ? 'text-blue1 font-bold' : '' }}" 
            href="{{ route('catalogue.index') }}"
        >
            Le catalogue
        </a>

        <!-- Ligne 2 : L'observatoire -->
        <a 
            class="text-blue2 font-medium text-lg hover:bg-gray-100 px-3 py-2 rounded text-center {{ request()->routeIs('home') ? 'text-blue1 font-bold' : '' }}" 
            href="{{ route('home') }}"
        >
            L'observatoire
        </a>

        <!-- Ligne 3 : À propos -->
        <a 
            class="text-blue2 font-medium text-lg hover:bg-gray-100 px-3 py-2 rounded text-center {{ request()->routeIs('about') ? 'text-blue1 font-bold' : '' }}" 
            href="{{ route('about') }}"
        >
            A propos
        </a>

        <!-- Actions d'authentification mobile -->
        @auth
            <a href="{{ route('catalogue.user_tab') }}" class="text-blue2 hover:bg-gray-100 px-3 py-2 rounded text-center"> {{ \Illuminate\Support\Facades\Auth::user()->name }} </a>
            <form action="{{ route('auth.logout') }}" method="post">
                @method("delete")
                @csrf
                <button type="submit" class="text-blue2 font-medium text-lg hover:bg-gray-100 px-3 py-2 rounded text-center"> Se déconnecter</button>
            </form>
        @endauth
        @guest
            <a href="{{ route('auth.login') }}" class="text-blue2 hover:bg-gray-100 px-3 py-2 rounded text-center"> Se connecter</a>
        @endguest
    </div>
  </nav>

  <script>
      // Script pour basculer le menu mobile
      document.getElementById('menu-toggle').addEventListener('click', function() {
          const menu = document.getElementById('mobile-menu');
          menu.classList.toggle('hidden');
      });
  </script>

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
  <div class="w-full min-h-96 md:px-8">
      @yield('content')
  </div>
</body>


<footer class="bg-blue2 mt-6" aria-labelledby="footer-heading">
  <h2 id="footer-heading" class="sr-only">Footer</h2>
  <div class="mx-auto max-w-7xl px-6 pb-8 pt-16 sm:pt-24 lg:px-8 lg:pt-32">
      <div class="flex flex-col items-center md:grid md:grid-cols-2 xl:gap-8">
          <!-- Logo + Réseaux sociaux (centrés sur mobile) -->
          <div class="flex flex-col items-center space-y-6 md:items-start md:space-y-8">
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

          <!-- Liens en deux colonnes (empilés sur mobile) -->
          <div class="mt-10 grid grid-cols-1 gap-8 md:grid-cols-2 md:mt-0">
              <div>
                  <h3 class="text-sm font-semibold leading-6 text-white">Catalogue</h3>
                  <ul role="list" class="mt-6 space-y-4">
                      <li><a href="/catalogue" class="text-sm leading-6 text-white hover:text-gray-200">Recherche</a></li>
                      <li><a href="/catalogue/mes-etudes" class="text-sm leading-6 text-white hover:text-gray-200">Ajout d'une étude</a></li>
                      <li><a href="/demande" class="text-sm leading-6 text-white hover:text-gray-200">Demande de compte</a></li>
                  </ul>
              </div>
              <div>
                  <h3 class="text-sm font-semibold leading-6 text-white">Informations</h3>
                  <ul role="list" class="mt-6 space-y-4">
                      <li><a href="/a-propos" class="text-sm leading-6 text-white hover:text-gray-200">Contact</a></li>
                      <li><a href="/" class="text-sm leading-6 text-white hover:text-gray-200">L'observatoire</a></li>
                      <li><a href="https://www.institut-ecocitoyen.fr/pres.php" class="text-sm leading-6 text-white hover:text-gray-200">L'institut</a></li>
                  </ul>
              </div>
          </div>
      </div>

      <!-- Copyright -->
      <div class="mt-16 border-t border-white/50 pt-8 sm:mt-20 lg:mt-24 text-center">
          <p class="text-xs leading-5 text-white">&copy; 2024 Institut écocitoyen pour la connaissance des pollutions. Tous droits réservés.</p>
      </div>
  </div>
</footer>

</html>
