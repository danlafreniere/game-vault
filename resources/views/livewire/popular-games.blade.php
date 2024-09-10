<div wire:init="fetch" class="popular-games text-sm grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6 gap-12 border-b border-gray-800 pb-16">
  @forelse ($popularGames as $game)
  <div class="game mt-8 flex flex-col justify-center items-center lg:block">
    <div class="relative inline-block min-w-[264px] lg:min-w-[168px] 2xl:min-w-[210px] min-h-[352px] lg:min-h-[224px] 2xl:min-h-[280px]">
      <a href="{{ route('games.show', $game['slug']) }}">
        <img class="hover:opacity-75 transition ease-in-out duration-150" src="{{ $game['cover_image_url'] }}" alt="Game cover" />
      </a>
      <div class="absolute bottom-[-20px] right-[-20px] h-16 w-16 bg-gray-800 rounded-full">
        <div class="font-semibold text-xs flex justify-center items-center h-full">{{ $game['rating'] }}</div>
      </div>
    </div>
    <a href="{{ route('games.show', $game['slug']) }}" class="block text-base font-semibold leading-tight hover:text-gray-500 mt-8">{{ $game['name'] }}</a>
    <div class="text-gray-500 mt-1">
      {{ $game['platforms'] }}
    </div>
  </div>
  @empty
  @foreach (range(1,18) as $game)
  <div class="game mt-8 flex flex-col justify-center animate-pulse items-center lg:block">
    <div class="relative inline-block">
      <div class="flex items-center justify-center w-[264px] lg:w-[168px] 2xl:w-[210px] h-[352px] lg:h-[224px] 2xl:h-[280px] bg-gray-300 rounded dark:bg-gray-700">
        <svg class="w-10 h-10 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
          <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z" />
        </svg>
      </div>
    </div>
    <div class="block mt-8 h-4 bg-gray-200 rounded-full dark:bg-gray-700 w-32 mb-4"></div>
    <div class="mt-1 h-4 bg-gray-200 rounded-full dark:bg-gray-700 w-40"></div>
  </div>
  @endforeach
  @endforelse
</div>
