<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MostAnticipated extends BaseGamesComponent
{

  /**
   * Most anticipated games data.
   *
   * @var array
   */
  public $mostAnticipated = [];

  /**
   * Fetch most anticipated games from IGDB API.
   */
  public function fetch()
  {
    try {
      $accessToken = $this->accessTokenService->getAccessToken();
    } catch (\Exception $e) {
      return;
    }
    $current = Carbon::now()->timestamp;
    $after = Carbon::now()->addMonths(4)->timestamp;
    $mostAnticipatedUnformatted = Cache::remember('mostAnticipated', 3600, function () use ($accessToken, $current, $after) {
      return Http::withHeaders([
        'Client-ID' => config('services.twitch_api.client_id'),
        'Authorization' => 'Bearer ' . $accessToken,
      ])->withBody(
        "fields name, cover.url, first_release_date, total_rating_count, slug;
                where platforms = (6,130,167,169)
                & (first_release_date >= {$current}
                & first_release_date < {$after})'
                & total_rating_count > 1;
                sort total_rating_count desc;
                limit 3;",
        'text/plain'
      )->post('https://api.igdb.com/v4/games')->json();
    });
    if (empty($mostAnticipatedUnformatted)) {
        $this->mostAnticipated = 'nodice';
    }
    else {
        $this->mostAnticipated = $this->formatDataForView($mostAnticipatedUnformatted);
    }
  }

  public function render()
  {
    return view('livewire.most-anticipated');
  }
}
