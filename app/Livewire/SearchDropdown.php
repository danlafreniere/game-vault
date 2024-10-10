<?php

namespace App\Livewire;

use App\Services\AccessTokenService;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class SearchDropdown extends Component
{

  /**
   * Access token.
   *
   * @var AccessTokenService
   */
  protected $accessTokenService;

  public $search = '';

  public $searchResults = [];

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

    public function render()
    {
      try {
        $accessToken = $this->accessTokenService->getAccessToken();
      } catch (\Exception $e) {
        return;
      }
      $this->searchResults = Http::withHeaders([
        'Client-ID' => config('services.twitch_api.client_id'),
        'Authorization' => 'Bearer ' . $accessToken,
      ])->withBody(
                "search \"{$this->search}\";
                fields name, slug, cover.url;
                limit 6;",
        'text/plain'
      )->post('https://api.igdb.com/v4/games')->json();
      return view('livewire.search-dropdown');
    }
}
