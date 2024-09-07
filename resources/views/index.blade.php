@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
  <h2 class="text-blue-500 uppercase tracking-wide font-semibold text-center lg:text-left">Popular Games</h2>
  <div class="popular-games text-sm grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6 gap-12 border-b border-gray-800 pb-16">
    @foreach ($popularGames as $game)
      <div class="game mt-8 flex flex-col justify-center items-center lg:block">
        <div class="relative inline-block">
          <a href="#">
            <img class="hover:opacity-75 transition ease-in-out duration-150" src="{{ Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']) }}" alt="Game cover"/>
          </a>
          <div class="absolute bottom-[-20px] right-[-20px] h-16 w-16 bg-gray-800 rounded-full">
            <div class="font-semibold text-xs flex justify-center items-center h-full">{{ isset($game['rating']) ? min(100, max(0, round($game['rating']))) . '%' : 'N/A' }}</div>
          </div>
        </div>
        <a href="#" class="block text-base font-semibold leading-tight hover:text-gray-500 mt-8">{{ $game['name'] }}</a>
        <div class="text-gray-500 mt-1">
          @foreach ($game['platforms'] as $platform)
            @if (array_key_exists('abbreviation', $platform))
              {{ $platform['abbreviation'] }},
            @endif
          @endforeach
        </div>
      </div>
    @endforeach
  </div>
  <div class="flex flex-col lg:flex-row my-10">
    <div class="recently-reviewed w-full lg:w-3/4 mr-0 lg:mr-32">
      <h2 class="text-blue-500 uppercase tracking-wide font-semibold text-center lg:text-left">Recently Reviewed</h2>
      <div class="gap-y-12 mt-8 flex flex-col">
        @foreach ($recentlyReviewedGames as $game)
          <div class="bg-gray-800 rounded-lg shadow-md flex px-6 py-6">
            <div class="inline-block flex-none">
              <div class="image-container relative">
                <a href="#">
                  <img class="w-48 hover:opacity-75 transition ease-in-out duration-150" src="{{ Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']) }}" alt="Game cover"/>
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
        @endforeach
      </div>
    </div>
    <div class="most-anticipated lg:w-1/4 mt-12 lg:mt-0">
      <h2 class="text-blue-500 uppercase tracking-wide font-semibold text-center lg:text-left">Most Anticipated</h2>
      <div class="gap-y-12 mt-8 flex flex-col">
        @foreach($mostAnticipatedGames as $game)
          <div class="flex">
            <a href="#">
              <img class="w-16 hover:opacity-75 transition ease-in-out duration-150" src="{{ Str::replaceFirst('thumb', 'cover_small', $game['cover']['url']) }}" alt="Game cover"/>
            </a>
            <div class="hover:text-gray-300 ml-4">
              <a href="#">{{ $game['name'] }}</a>
              <p class="text-gray-400 text-sm mt-1">{{ Carbon\Carbon::parse($game['first_release_date'])->format('M d, Y') }}</p>
            </div>
          </div>
        @endforeach
      </div>
      <h2 class="text-blue-500 uppercase tracking-wide font-semibold mt-12 text-center lg:text-left">Coming Soon</h2>
      <div class="gap-y-12 mt-8 flex flex-col">
        @foreach($gamesComingSoon as $game)
          <div class="flex">
            <a href="#">
              <img class="w-16 hover:opacity-75 transition ease-in-out duration-150" src="{{ Str::replaceFirst('thumb', 'cover_small', $game['cover']['url']) }}" alt="Game cover"/>
            </a>
            <div class="hover:text-gray-300 ml-4">
              <a href="#">{{ $game['name'] }}</a>
              <p class="text-gray-400 text-sm mt-1">{{ Carbon\Carbon::parse($game['first_release_date'])->format('M d, Y') }}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
