<?php

namespace App\Http\Controllers;

use App\Services\AccessTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GamesController extends Controller
{

  /**
   * The access token service.
   *
   * @var AccessTokenService
   */
  protected $accessTokenService;

  public function __construct(AccessTokenService $accessTokenService)
  {
    $this->accessTokenService = $accessTokenService;
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param string $slug
   *   The game slug.
   */
  public function show(string $slug)
  {
    try {
      $accessToken = $this->accessTokenService->getAccessToken();
    } catch (\Exception $e) {
      return;
    }
    $unformattedGameData = Http::withHeaders([
      'Client-ID' => config('services.twitch_api.client_id'),
      'Authorization' => 'Bearer ' . $accessToken,
    ])->withBody(
      "fields name, cover.url, first_release_date, total_rating_count,
        platforms.abbreviation, rating, aggregated_rating, summary, slug, involved_companies.company.name,
        genres.name, websites.*, videos.*, screenshots.*, similar_games.cover.url,
        similar_games.name, similar_games.slug, similar_games.rating, similar_games.rating_count, similar_games.platforms.abbreviation;
          where slug = \"{$slug}\";",
      'text/plain'
    )->post('https://api.igdb.com/v4/games')->json();
    abort_if(empty($unformattedGameData), 404);
    $gameData = $this->formatDataForView($unformattedGameData);
    return view('show', ['game' => $gameData[0]]);
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
        'cover_image_url' => isset($game['cover']) ? str_replace('thumb', 'cover_big', $game['cover']['url']) : NULL,
        'platforms' => isset($game['platforms']) ? collect($game['platforms'])->pluck('abbreviation')->implode(', ') : NULL,
        'genres' => isset($game['genres']) ? collect($game['genres'])->pluck('name')->implode(', ') : NULL,
        'involved_companies' => isset($game['involved_companies']) ? collect($game['involved_companies'])->pluck('company.name')->implode(', ') : NULL,
        'member_rating' => isset($game['rating']) ? min(100, max(0, round($game['rating']))) : 'N/A',
        'critic_rating' => isset($game['aggregated_rating']) ? min(100, max(0, round($game['aggregated_rating']))) : 'N/A',
        'trailer' => isset($game['videos']) ? 'https://youtube.com/embed/' . $game['videos'][0]['video_id'] : NULL,
        'slug' => isset($game['slug']) ? $game['slug'] : NULL,
        'screenshots' => isset($game['screenshots']) ? collect($game['screenshots'])->map(function ($screenshot) {
          return [
            'big' => str_replace('thumb', 'screenshot_big', $screenshot['url']),
            'huge' => str_replace('thumb', 'screenshot_huge', $screenshot['url']),
          ];
        })->take(9) : NULL,
        'similar_games' => isset($game['similar_games']) ? collect($game['similar_games'])->map(function ($similarGame) {
          return [
            'cover_image_url' => isset($similarGame['cover']) ? str_replace('thumb', 'cover_big', $similarGame['cover']['url']) : NULL,
            'rating' => isset($similarGame['rating']) ? min(100, max(0, round($similarGame['rating']))) : 'N/A',
            'slug' => isset($similarGame['slug']) ? $similarGame['slug'] : NULL,
            'rating_count' => isset($similarGame['rating_count']) ? $similarGame['rating_count'] : NULL,
            'name' => isset($similarGame['name']) ? $similarGame['name'] : NULL,
            'platforms' => isset($similarGame['platforms']) ? collect($similarGame['platforms'])->pluck('abbreviation')->implode(', ') : NULL,
          ];
        })->take(6) : NULL,
        'social' => [
          'website' => isset($game['websites']) ? collect($game['websites'])->filter(function ($website) {
            return strpos($website['url'], 'store.steampowered') !== false;
          })->first() : NULL,
          'facebook' => isset($game['websites']) ? collect($game['websites'])->filter(function ($website) {
            return strpos($website['url'], 'facebook') !== false;
          })->first() : NULL,
          'twitter' => isset($game['websites']) ? collect($game['websites'])->filter(function ($website) {
            return strpos($website['url'], 'twitter') !== false;
          })->first() : NULL,
          'instagram' => isset($game['websites']) ? collect($game['websites'])->filter(function ($website) {
            return strpos($website['url'], 'instagram') !== false;
          })->first() : NULL,
        ],
      ]);
    });
  }


  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
