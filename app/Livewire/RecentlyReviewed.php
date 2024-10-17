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
    $recentlyReviewedUnformatted = Cache::remember('recentlyReviewed', 3600, function () use ($accessToken, $before, $current) {
      return Http::withHeaders([
        'Client-ID' => config('services.twitch_api.client_id'),
        'Authorization' => 'Bearer ' . $accessToken,
      ])->withBody(
        "fields name, cover.url, first_release_date, aggregated_rating, aggregated_rating_count, total_rating_count, rating_count, platforms.abbreviation, rating, summary, slug;
                where platforms = (6,130,167,169)
                & (first_release_date >= {$before}
                & first_release_date < {$current})
                & aggregated_rating_count > 3;
                limit 3;
                sort first_release_date desc;",
        'text/plain'
      )->post('https://api.igdb.com/v4/games')->json();
    });
    $this->recentlyReviewed = $this->formatDataForView($recentlyReviewedUnformatted);
  }

  public function initializeRecentGameRatingAnimation(string $id)
  {
    // dump($id, collect($this->recentlyReviewed));
    $game = collect($this->recentlyReviewed)->firstWhere('slug', $id);
    if (!$game) {
      return;
    }
    $this->dispatch('recentGameRatingAnimation', slug: $game['slug'], rating: $game['critic_rating']);
  }

  public function render()
  {
    return view('livewire.recently-reviewed');
  }
}
