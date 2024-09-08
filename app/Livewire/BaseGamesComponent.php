<?php

namespace App\Livewire;

use App\Services\AccessTokenService;
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
}
