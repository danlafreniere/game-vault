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

  /**
   * Format data for view.
   *
   * @param array $data
   *  Data to format.
   *
   * @return \Illuminate\Support\Collection
   *  Formatted data.
   */
  protected function formatDataForView(array $data)
  {
    return collect($data)->map(function ($game) {
      return collect($game)->merge([
        'cover_image_url' => isset($game['cover']) ? str_replace('thumb', 'cover_big', $game['cover']['url']) : null,
        'rating' => isset($game['rating']) ? min(100, max(0, round($game['rating']))) . '%' : 'N/A',
        'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', '),
      ]);
    });
  }

  public function render()
  {
    return view('livewire.popular-games');
  }
}
