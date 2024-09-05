<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Game Vault</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 h-screen text-white">
  <header class="border-b border-gray-800">
    <nav class="container mx-auto flex flex-col lg:flex-row items-center justify-between px-4 py-6">
      <div class="flex items-center flex-col lg:flex-row">
        <a href="/">
          <img src="/images/logo.svg" alt="Game Vault" class="h-8 flex-none">
        </a>
        <ul class="flex ml-0 lg:ml-16 mt-2 lg:mt-0 items-center gap-8">
          <li><a href="#" class="hover:text-gray-500">Games</a></li>
          <li><a href="#" class="hover:text-gray-500">Reviews</a></li>
          <li><a href="#" class="hover:text-gray-500">Coming Soon</a></li>
        </ul>
      </div>
      <div class="flex items-center mt-2 lg:mt-0">
        <div class="relative">
          <input type="text" class="bg-gray-800 text-sm rounded-full w-64 px-3 py-1 focus:outline-none focus:ring pl-8" placeholder="Search...">
          <div class="absolute top-0 flex items-center h-full ml-2">
            <svg class="stroke-current text-gray-400 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
          </div>
        </div>
        <div class="ml-6">
          <a href="#">
            <img src="/images/avatar.jpg" alt="avatar" class="rounded-full w-8">
          </a>
        </div>
      </div>
  </header>
  <main class="py-8">
    @yield('content')
  </main>
  <footer class="border-t border-gray-800">
    <div class="container mx-auto px-4 py-6">
      Powered by <a href="https://www.igdb.com/api" target="_blank" class="underline hover:text-gray-500">IGDB API</a>
    </div>
  </footer>
</body>
</html>
