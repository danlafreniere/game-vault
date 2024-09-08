<?php

namespace App\Livewire;

use App\Traits\AuthTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class PopularGames extends Component
{

  use AuthTrait;

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
    $accessToken = $this->getAccessToken();
    if (!$accessToken) {
      return;
    }
    $before = Carbon::now()->subMonths(2)->timestamp;
    $after = Carbon::now()->addMonths(2)->timestamp;
    $this->popularGames = Cache::remember('popularGames', 3600, function () use ($accessToken, $before, $after) {
      return Http::withHeaders([
        'Client-ID' => config('services.twitch_api.client_id'),
        'Authorization' => 'Bearer ' . $accessToken,
      ])->withBody(
        "fields name, cover.url, first_release_date, total_rating_count, platforms.abbreviation, rating;
                where platforms = (6,130,167,169)
                & (first_release_date >= {$before}
                & first_release_date < {$after})
                & total_rating_count > 10;
                sort total_rating_count desc;
                limit 20;",
        'text/plain'
      )->post('https://api.igdb.com/v4/games')->json();
    });
  }

  public function render()
  {
    return view('livewire.popular-games');
  }
}
