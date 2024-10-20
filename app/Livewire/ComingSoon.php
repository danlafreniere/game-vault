<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ComingSoon extends BaseGamesComponent
{

  /**
   * Games coming soon data.
   *
   * @var array
   */
  public $comingSoon = [];

  /**
   * Fetch games coming soon from IGDB API.
   */
  public function fetch()
  {
    try {
      $accessToken = $this->accessTokenService->getAccessToken();
    } catch (\Exception $e) {
      return;
    }
    $current = Carbon::now()->timestamp;
    $comingSoonUnformatted = Cache::remember('comingSoon', 3600, function () use ($accessToken, $current) {
      return Http::withHeaders([
        'Client-ID' => config('services.twitch_api.client_id'),
        'Authorization' => 'Bearer ' . $accessToken,
      ])->withBody(
        "fields name, cover.url, first_release_date, total_rating_count, slug;
                where platforms = (6,130,167,169)
                & first_release_date >= {$current};
                sort first_release_date asc;
                limit 3;",
        'text/plain'
      )->post('https://api.igdb.com/v4/games')->json();
    });
    $this->comingSoon = $this->formatDataForView($comingSoonUnformatted);
  }

  public function render()
  {
    return view('livewire.coming-soon');
  }
}
