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
