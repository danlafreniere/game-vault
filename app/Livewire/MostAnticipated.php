<?php

namespace App\Livewire;

use App\Traits\AuthTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class MostAnticipated extends Component
{

  use AuthTrait;

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
    $accessToken = $this->getAccessToken();
    if (!$accessToken) {
      return;
    }
    $current = Carbon::now()->timestamp;
    $after = Carbon::now()->addMonths(4)->timestamp;
    $this->mostAnticipated = Cache::remember('mostAnticipated', 3600, function () use ($accessToken, $current, $after) {
      return Http::withHeaders([
        'Client-ID' => config('services.twitch_api.client_id'),
        'Authorization' => 'Bearer ' . $accessToken,
      ])->withBody(
        "fields name, cover.url, first_release_date, total_rating_count;
                where platforms = (6,130,167,169)
                & (first_release_date >= {$current}
                & first_release_date < {$after})
                & total_rating_count > 1;
                limit 4;
                sort total_rating_count desc;",
        'text/plain'
      )->post('https://api.igdb.com/v4/games')->json();
    });
  }

  public function render()
  {
    return view('livewire.most-anticipated');
  }
}
