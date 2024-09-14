<div class="flex">
  <a href="{{ route('games.show', $game['slug']) }}">
    <img class="w-16 hover:opacity-75 transition ease-in-out duration-150" src="{{ $game['cover_image_url'] }}" alt="Game cover" />
  </a>
  <div class="hover:text-gray-300 ml-4">
    <a href="{{ route('games.show', $game['slug']) }}">{{ $game['name'] }}</a>
    <p class="text-gray-400 text-sm mt-1">{{ $game['release'] }}</p>
  </div>
</div>
