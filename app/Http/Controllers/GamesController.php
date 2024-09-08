<?php

namespace App\Http\Controllers;

use App\Traits\AuthTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GamesController extends Controller
{

  use AuthTrait;

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    try {
      // $accessToken = $this->getAccessToken();
      // if (!isset($accessToken)) {
      //     throw new \Exception('Failed to obtain access token');
      // }
      // $mostAnticipatedGames = $this->fetchMostAnticipatedGames($accessToken);
      // if (!isset($mostAnticipatedGames)) {
      //     throw new \Exception('Failed to fetch most anticipated games.');
      // }
      // $gamesComingSoon = $this->fetchGamesComingSoon($accessToken);
      // if (!isset($gamesComingSoon)) {
      //     throw new \Exception('Failed to fetch games coming soon.');
      // }
      return view(
        'index',
        [
          // 'mostAnticipatedGames' => $mostAnticipatedGames,
          // 'gamesComingSoon' => $gamesComingSoon,
        ]
      );
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      return response()->json(['error' => $e->getMessage()], 500);
    }
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
   */
  public function show(string $id)
  {
    //
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
