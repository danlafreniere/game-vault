<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RecentlyReviewed extends BaseGamesComponent
{

  /**
   * Recently reviewed games data.
   *
   * @var array
   */
  public $recentlyReviewed = [];

  /**
   * Fetch recently reviewed games from IGDB API.
   */
  public function fetch()
  {
    try {
      $accessToken = $this->accessTokenService->getAccessToken();
    } catch (\Exception $e) {
      return;
    }
    $before = Carbon::now()->subMonths(2)->timestamp;
    $current = Carbon::now()->timestamp;
    $this->recentlyReviewed = Cache::remember('recentlyReviewed', 3600, function () use ($accessToken, $before, $current) {
      return Http::withHeaders([
        'Client-ID' => config('services.twitch_api.client_id'),
        'Authorization' => 'Bearer ' . $accessToken,
      ])->withBody(
        "fields name, cover.url, first_release_date, total_rating_count, rating_count, platforms.abbreviation, rating, summary;
                where platforms = (6,130,167,169)
                & (first_release_date >= {$before}
                & first_release_date < {$current})
                & rating_count > 10;
                limit 3;
                sort rating_count desc;",
        'text/plain'
      )->post('https://api.igdb.com/v4/games')->json();
    });
  }

  public function render()
  {
    return view('livewire.recently-reviewed');
  }
}
