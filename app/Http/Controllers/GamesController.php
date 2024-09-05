<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GamesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $credentials = $this->getOAuthToken();
            if (!isset($credentials['access_token'])) {
                throw new \Exception('Failed to obtain access token');
            }
            $popularGames = $this->fetchPopularGames($credentials['access_token']);
            if (!isset($popularGames)) {
                throw new \Exception('Failed to fetch popular games');
            }
            dd($popularGames);
        //     return view('games.index', ['games' => $popularGames]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Obtain OAuth token from Twitch API.
     */
    private function getOAuthToken()
    {
        return Http::withOptions([
            'query' => [
                'client_id' => config('services.twitch_api.client_id'),
                'client_secret' => config('services.twitch_api.client_secret'),
                'grant_type' => 'client_credentials'
            ]
        ])->post('https://id.twitch.tv/oauth2/token')->json();
    }

    /**
     * Fetch popular games from IGDB API using the access token.
     */
    private function fetchPopularGames($accessToken)
    {
        return Http::withHeaders([
            'Client-ID' => config('services.twitch_api.client_id'),
            'Authorization' => 'Bearer ' . $accessToken,
        ])->withBody(
            'fields name, total_rating_count; sort total_rating_count desc; limit 20;',
            'text/plain'
        )->post('https://api.igdb.com/v4/games')->json();
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
