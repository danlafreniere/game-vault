<div wire:init="fetch" class="gap-y-12 mt-8 flex flex-col">
  @forelse ($recentlyReviewed as $game)
  <div class="bg-gray-800 rounded-lg shadow-md flex px-6 py-6">
    <div class="inline-block flex-none">
      <div class="image-container relative min-h-[256px] min-w-[192px]">
        <a href="{{ route('games.show', $game['slug']) }}">
          <img class="w-48 hover:opacity-75 transition ease-in-out duration-150" src="{{ $game['cover_image_url'] }}" alt="Game cover" />
        </a>
        <div class="absolute bottom-[-20px] right-[-20px] h-16 w-16 bg-gray-900 rounded-full">
          <div class="font-semibold text-xs flex justify-center items-center h-full">
            {{ $game['rating'] }}
          </div>
        </div>
      </div>
    </div>
    <div class="ml-12">
      <a href="{{ route('games.show', $game['slug']) }}" class="block text-lg font-semibold leading-tight hover:text-gray-500 mt-4">{{ $game['name'] }}</a>
      <div class="text-gray-400 mt-1">
        {{ $game['platforms'] }}
      </div>
      <p class="mt-6 text-gray-400 block">{{ $game['summary'] }}</p>
    </div>
  </div>
  @empty
  @foreach (range(1,3) as $game)
  <div class="bg-gray-800 rounded-lg shadow-md flex px-6 py-6 animate-pulse">
    <div class="inline-block flex-none">
      <div class="image-container relative">
        <div class="flex items-center justify-center bg-gray-300 rounded dark:bg-gray-700 h-[256px] w-[192px]">
          <svg class="w-10 h-10 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
            <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z" />
          </svg>
        </div>
      </div>
    </div>
    <div class="ml-12 w-full">
      <div class="block mt-6 h-4 bg-gray-200 rounded-full dark:bg-gray-700 w-40 mb-4"></div>
      <div class="mt-1 h-4 bg-gray-200 rounded-full dark:bg-gray-700 w-48"></div>
      <div class="mt-8 h-4 bg-gray-200 rounded-full dark:bg-gray-700 w-full"></div>
      <div class="mt-4 h-4 bg-gray-200 rounded-full dark:bg-gray-700 w-full"></div>
      <div class="mt-4 h-4 bg-gray-200 rounded-full dark:bg-gray-700 w-full"></div>
      <div class="mt-4 h-4 bg-gray-200 rounded-full dark:bg-gray-700 w-1/2"></div>
    </div>
  </div>
  @endforeach
  @endforelse
</div>
