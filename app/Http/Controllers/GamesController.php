<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
                throw new \Exception('Failed to fetch popular games.');
            }
            $recentlyReviewedGames = $this->fetchRecentlyReviewedGames($credentials['access_token']);
            if (!isset($recentlyReviewedGames)) {
                throw new \Exception('Failed to fetch recently reviewed games.');
            }
            $mostAnticipatedGames = $this->fetchMostAnticipatedGames($credentials['access_token']);
            if (!isset($mostAnticipatedGames)) {
                throw new \Exception('Failed to fetch most anticipated games.');
            }
            $gamesComingSoon = $this->fetchGamesComingSoon($credentials['access_token']);
            if (!isset($gamesComingSoon)) {
                throw new \Exception('Failed to fetch games coming soon.');
            }
            return view('index', [
                    'popularGames' => $popularGames,
                    'recentlyReviewedGames' => $recentlyReviewedGames,
                    'mostAnticipatedGames' => $mostAnticipatedGames,
                    'gamesComingSoon' => $gamesComingSoon,
                ]
            );
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
     * Fetch popular games from IGDB API.
     */
    private function fetchPopularGames(string $accessToken)
    {
        $before = Cache::remember('before_timestamp', 60, function () {
            return Carbon::now()->subMonths(2)->timestamp;
        });
        $after = Cache::remember('after_timestamp', 60, function () {
            return Carbon::now()->addMonths(2)->timestamp;
        });
        return Http::withHeaders([
            'Client-ID' => config('services.twitch_api.client_id'),
            'Authorization' => 'Bearer ' . $accessToken,
        ])->withBody(
            "fields name, cover.url, first_release_date, total_rating_count, platforms.abbreviation, rating;
            where platforms = (6,130,167,169)
            & (first_release_date >= {$before}
            & first_release_date < {$after})
            & total_rating_count > 10;
            sort total_rating_count desc;
            limit 20;",
            'text/plain'
        )->post('https://api.igdb.com/v4/games')->json();
    }

    /**
     * Fetch recently reviewed games from IGDB API.
     */
    private function fetchRecentlyReviewedGames(string $accessToken)
    {
        $before = Cache::remember('before_timestamp', 60, function () {
            return Carbon::now()->subMonths(2)->timestamp;
        });
        $current = Cache::remember('current_timestamp', 60, function () {
            return Carbon::now()->timestamp;
        });
        return Http::withHeaders([
            'Client-ID' => config('services.twitch_api.client_id'),
            'Authorization' => 'Bearer ' . $accessToken,
        ])->withBody(
            "fields name, cover.url, first_release_date, total_rating_count, platforms.abbreviation, rating, summary;
            where platforms = (6,130,167,169)
            & (first_release_date >= {$before}
            & first_release_date < {$current})
            & total_rating_count > 10;
            limit 3;
            sort total_rating_count desc;",
            'text/plain'
        )->post('https://api.igdb.com/v4/games')->json();
    }

    /**
     * Fetch most anticipated games from IGDB API.
     */
    private function fetchMostAnticipatedGames(string $accessToken)
    {
        $current = Cache::remember('current_timestamp', 60, function () {
            return Carbon::now()->timestamp;
        });
        $after = Cache::remember('after_timestamp_4', 60, function () {
            return Carbon::now()->addMonths(4)->timestamp;
        });
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
    }

    /**
     * Fetch games coming soon from IGDB API.
     */
    private function fetchGamesComingSoon(string $accessToken)
    {
        $current = Cache::remember('current_timestamp', 60, function () {
            return Carbon::now()->timestamp;
        });
        return Http::withHeaders([
            'Client-ID' => config('services.twitch_api.client_id'),
            'Authorization' => 'Bearer ' . $accessToken,
        ])->withBody(
            "fields name, cover.url, first_release_date, total_rating_count;
            where platforms = (6,130,167,169)
            & first_release_date >= {$current}
            & total_rating_count > 1;
            limit 4;
            sort total_rating_count desc;",
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
