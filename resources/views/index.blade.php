@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
  <h2 class="text-blue-500 uppercase tracking-wide font-semibold text-center lg:text-left">Popular Games</h2>
  <livewire:popular-games />
  <div class="flex flex-col lg:flex-row my-10">
    <div class="recently-reviewed w-full lg:w-3/4 mr-0 lg:mr-32">
      <h2 class="text-blue-500 uppercase tracking-wide font-semibold text-center lg:text-left">Recently Reviewed</h2>
      <livewire:recently-reviewed />
    </div>
    <div class="most-anticipated lg:w-1/4 mt-12 lg:mt-0">
      <h2 class="text-blue-500 uppercase tracking-wide font-semibold text-center lg:text-left">Most Anticipated</h2>
      <livewire:most-anticipated />
      <h2 class="text-blue-500 uppercase tracking-wide font-semibold mt-12 text-center lg:text-left">Coming Soon</h2>
      <livewire:coming-soon />
    </div>
  </div>
</div>
@endsection
