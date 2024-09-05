@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
  <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Popular Games</h2>
  <div class="popular-games text-sm grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6 gap-12 border-b border-gray-800 pb-16">
    <div class="game mt-8">
      <div class="relative inline-block">
        <a href="#">
          <img class="hover:opacity-75 transition ease-in-out duration-150" src="/images/doom.jpg" alt="Game cover"/>
        </a>
        <div class="absolute bottom-[-20px] right-[-20px] h-16 w-16 bg-gray-800 rounded-full">
          <div class="font-semibold text-xs flex justify-center items-center h-full">80%</div>
        </div>
      </div>
      <a href="#" class="block text-base font-semibold leading-tight hover:text-gray-500 mt-8">Doom Eternal</a>
      <div class="text-gray-500 mt-1">PlayStation 5</div>
    </div>
  </div>
  <div class="flex flex-col lg:flex-row my-10">
      <div class="recently-reviewed w-full lg:w-3/4 mr-0 lg:mr-32">
        <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Recently Reviewed</h2>
        <div class="gap-y-12 mt-8 flex flex-col">
          <div class="bg-gray-800 rounded-lg shadow-md flex px-6 py-6">
              <div class="relative inline-block flex-none">
                <a href="#">
                  <img class="w-48 hover:opacity-75 transition ease-in-out duration-150" src="/images/doom.jpg" alt="Game cover"/>
                </a>
                <div class="absolute bottom-[-20px] right-[-20px] h-16 w-16 bg-gray-900 rounded-full">
                <div class="font-semibold text-xs flex justify-center items-center h-full">80%</div>
              </div>
            </div>
            <div class="ml-12">
                <a href="#" class="block text-lg font-semibold leading-tight hover:text-gray-500 mt-4">Doom Eternal</a>
                <div class="text-gray-400 mt-1">Playstation 5</div>
                <p class="mt-6 text-gray-400 hidden md:block">Become the Slayer in an epic single-player campaign to conquer demons across dimensions and stop the final destruction of humanity.</p>
              </div>
          </div>
        </div>
      </div>
      <div class="most-anticipated lg:w-1/4 mt-12 lg:mt-0">
        <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Most Anticipated</h2>
        <div class="gap-y-12 mt-8 flex flex-col">
          <div class="flex">
            <a href="#">
              <img class="w-16 hover:opacity-75 transition ease-in-out duration-150" src="/images/doom.jpg" alt="Game cover"/>
            </a>
            <div class="hover:text-gray-300 ml-4">
              <a href="#">Doom Eternal</a>
              <p class="text-gray-400 text-sm mt-1">Sept 30, 2024</p>
            </div>
          </div>
        </div>
        <h2 class="text-blue-500 uppercase tracking-wide font-semibold mt-12">Coming Soon</h2>
        <div class="gap-y-12 mt-8 flex flex-col">
          <div class="flex">
            <a href="#">
              <img class="w-16 hover:opacity-75 transition ease-in-out duration-150" src="/images/doom.jpg" alt="Game cover"/>
            </a>
            <div class="hover:text-gray-300 ml-4">
              <a href="#">Doom Eternal</a>
              <p class="text-gray-400 text-sm mt-1">Sept 30, 2024</p>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
@endsection
