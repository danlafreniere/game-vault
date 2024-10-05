<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PopularGames extends BaseGamesComponent
{

  /**
   * Popular games data.
   *
   * @var array
   */
  public $popularGames = [];

  /**
   * Fetch popular games from IGDB API.
   */
  public function fetch()
  {
    try {
      $accessToken = $this->accessTokenService->getAccessToken();
    } catch (\Exception $e) {
      return;
    }
    $before = Carbon::now()->subMonths(2)->timestamp;
    $after = Carbon::now()->addMonths(2)->timestamp;
    $popularGamesUnformatted = Cache::remember('popularGames', 3600, function () use ($accessToken, $before, $after) {
      return Http::withHeaders([
        'Client-ID' => config('services.twitch_api.client_id'),
        'Authorization' => 'Bearer ' . $accessToken,
      ])->withBody(
        "fields name, cover.url, first_release_date, total_rating_count, platforms.abbreviation, rating, rating_count, slug;
                where platforms = (6,130,167,169)
                & (first_release_date >= {$before}
                & first_release_date < {$after})
                & rating_count > 5;
                sort rating_count desc;
                limit 20;",
        'text/plain'
      )->post('https://api.igdb.com/v4/games')->json();
    });
    $this->popularGames = $this->formatDataForView($popularGamesUnformatted);
  }

  public function render()
  {
    return view('livewire.popular-games');
  }

  // public function rendered()
  // {
  //     collect($this->popularGames)->filter(function ($game) {
  //         return $game['rating'];
  //     })->each(function ($game) {
  //         $this->dispatch('gameWithRatingAdded', slug: $game['slug'], rating: $game['rating']);
  //     });
  // }

  public function initializeGameRatingAnimation(string $id)
  {
    $game = collect($this->popularGames)->firstWhere('slug', $id);
    $this->dispatch('gameRatingAnimation', slug: $game['slug'], rating: $game['rating']);
  }
}
