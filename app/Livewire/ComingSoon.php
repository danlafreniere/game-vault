<?php

namespace App\Livewire;

use App\Traits\AuthTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ComingSoon extends Component
{

  use AuthTrait;

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
    $accessToken = $this->getAccessToken();
    if (!$accessToken) {
      return;
    }
    $current = Carbon::now()->timestamp;
    $this->comingSoon = Cache::remember('comingSoon', 3600, function () use ($accessToken, $current) {
      return Http::withHeaders([
        'Client-ID' => config('services.twitch_api.client_id'),
        'Authorization' => 'Bearer ' . $accessToken,
      ])->withBody(
        "fields name, cover.url, first_release_date, total_rating_count;
                where platforms = (6,130,167,169)
                & first_release_date >= {$current}
                & total_rating_count > 1;
                limit 4;
                sort total_rating_count desc;",
        'text/plain'
      )->post('https://api.igdb.com/v4/games')->json();
    });
  }

  public function render()
  {
    return view('livewire.coming-soon');
  }
}
