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
    $gameData = Http::withHeaders([
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
    abort_if(empty($gameData), 404);
    return view('show', ['game' => $gameData[0]]);
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
