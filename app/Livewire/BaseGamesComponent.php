<?php

namespace App\Livewire;

use App\Services\AccessTokenService;
use Carbon\Carbon;
use Livewire\Component;

class BaseGamesComponent extends Component
{

  /**
   * Recently reviewed games data.
   *
   * @var array
   */
  public $recentlyReviewed = [];

  /**
   * Access token.
   *
   * @var AccessTokenService
   */
  protected $accessTokenService;

  /**
   * Mount the popular games component.
   *
   * @param \App\Services\AccessTokenService $accessTokenService
   *   The access token service.
   */
  public function boot(AccessTokenService $accessTokenService)
  {
    $this->accessTokenService = $accessTokenService;
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
        'cover_image_url' => isset($game['cover']) ? str_replace('thumb', '720p', $game['cover']['url']) : '/images/image-not-found.svg',
        'release' => isset($game['first_release_date']) ? Carbon::parse($game['first_release_date'])->format('M d, Y') : NULL,
        'rating' => isset($game['rating']) ? min(100, max(0, round($game['rating']))) : 'N/A',
        'critic_rating' => isset($game['aggregated_rating']) ? min(100, max(0, round($game['aggregated_rating']))) : 'N/A',
        'platforms' => isset($game['platforms']) ? collect($game['platforms'])->pluck('abbreviation')->implode(', ') : NULL,
      ]);
    });
  }
}
