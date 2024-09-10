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
                limit 3;",
        'text/plain'
      )->post('https://api.igdb.com/v4/games')->json();
    });
    $this->comingSoon = $this->formatDataForView($comingSoonUnformatted);
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
        'cover_image_url' => isset($game['cover']) ? str_replace('thumb', 'cover_small', $game['cover']['url']) : null,
        'release' => Carbon::parse($game['first_release_date'])->format('M d, Y'),
      ]);
    });
  }

  public function render()
  {
    return view('livewire.coming-soon');
  }
}
