<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AccessTokenService
{
  public function getAccessToken()
  {
    if (Cache::has('twitch_access_token')) {
      return Cache::get('twitch_access_token');
    }

    try {
      $response = Http::withOptions([
        'query' => [
          'client_id' => config('services.twitch_api.client_id'),
          'client_secret' => config('services.twitch_api.client_secret'),
          'grant_type' => 'client_credentials'
        ]
      ])->post('https://id.twitch.tv/oauth2/token')->json();

      if (!isset($response['access_token'])) {
        throw new \Exception('Failed to obtain access token');
      }

      // Store the access token in the cache for 60 minutes
      Cache::put('twitch_access_token', $response['access_token'], 60);
      return $response['access_token'];
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      return null;
    }
  }
}
