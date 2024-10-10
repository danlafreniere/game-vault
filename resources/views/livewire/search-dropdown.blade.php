<div class="relative">
  <input wire:model.debounce.300ms.live="search" type="text" class="bg-gray-800 text-sm rounded-full w-64 px-3 py-1 focus:outline-none focus:ring pl-8" placeholder="Search...">
  <div class="absolute top-0 flex items-center h-full ml-2">
    <svg class="stroke-current text-gray-400 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
      <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
    </svg>
  </div>
  <div class="absolute z-50 bg-gray-800 text-xs rounded w-64 mt-2">
    <ul>
      @foreach($searchResults as $game)
      <li class="border-b border-gray-700">
        <a href="{{ route('games.show', $game['slug']) }}" class="hover:bg-gray-700 p-3 flex items-center transition ease-in-out duration-150">
          @if (isset($game['cover']))
          <img src="{{str_replace('thumb', 'cover_small', $game['cover']['url'])}}" alt="game cover" class="w-10">
          @else
          <img src="https://via.placeholder.com/264x352" alt="game cover" class="w-10">
          @endif
          <span class="ml-4">{{ $game['name'] }}</span>
        </a>
      </li>
      @endforeach
    </ul>
  </div>
</div>
