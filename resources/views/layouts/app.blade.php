<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Game Vault</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  @vite('resources/css/app.css')
  @livewireStyles
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-900 h-screen text-white">
  <header class="border-b border-gray-800">
    <nav class="container mx-auto flex flex-col lg:flex-row items-center justify-between px-4 py-6">
      <div class="flex items-center flex-col lg:flex-row">
        <a href="/">
          <img src="{{ asset('/images/logo.svg') }}" alt="Game Vault" class="h-8 flex-none">
        </a>
        <ul class="flex ml-0 lg:ml-16 mt-2 lg:mt-0 items-center gap-8">
          <li><a href="#" class="hover:text-gray-500">Games</a></li>
          <li><a href="#" class="hover:text-gray-500">Reviews</a></li>
          <li><a href="#" class="hover:text-gray-500">Coming Soon</a></li>
        </ul>
      </div>
      <div class="flex items-center mt-2 lg:mt-0">
        <livewire:search-dropdown />
        <div class="ml-6">
          <a href="#">
            <img src="{{ asset('images/avatar.jpg') }}" alt="avatar" class="rounded-full w-8">
          </a>
        </div>
      </div>
    </nav>
  </header>
  <main class="py-8">
    @yield('content')
  </main>
  <footer class="border-t border-gray-800">
    <div class="container mx-auto px-4 py-6">
      Powered by <a href="https://www.igdb.com/api" target="_blank" class="underline hover:text-gray-500">IGDB API</a>
    </div>
    @livewireScripts
      @vite('resources/js/app.js')
      @stack('scripts')
  </footer>
</body>
</html>
