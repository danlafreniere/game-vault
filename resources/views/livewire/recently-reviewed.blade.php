<div wire:init="fetch" class="gap-y-12 mt-8 flex flex-col">
  @forelse ($recentlyReviewed as $game)
  <div class="bg-gray-800 rounded-lg shadow-md flex px-6 py-6">
    <div class="inline-block flex-none">
      <div class="image-container relative">
        <a href="#">
          <img class="w-48 hover:opacity-75 transition ease-in-out duration-150" src="{{ Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']) }}" alt="Game cover" />
        </a>
        <div class="absolute bottom-[-20px] right-[-20px] h-16 w-16 bg-gray-900 rounded-full">
          <div class="font-semibold text-xs flex justify-center items-center h-full">
            {{ isset($game['rating']) ? min(100, max(0, round($game['rating']))) . '%' : 'N/A' }}
          </div>
        </div>
      </div>
    </div>
    <div class="ml-12">
      <a href="#" class="block text-lg font-semibold leading-tight hover:text-gray-500 mt-4">{{ $game['name'] }}</a>
      <div class="text-gray-400 mt-1">
        @foreach ($game['platforms'] as $platform)
        @if (array_key_exists('abbreviation', $platform))
        {{ $platform['abbreviation'] }},
        @endif
        @endforeach
      </div>
      <p class="mt-6 text-gray-400 block">{{ $game['summary'] }}</p>
    </div>
  </div>
  @empty
  <svg class="animate-spin mt-8 h-8 w-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
  </svg>
  @endforelse
</div>
