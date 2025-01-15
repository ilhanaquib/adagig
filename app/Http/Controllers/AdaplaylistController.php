<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class AdaplaylistController extends Controller
{
    public function index()
    {
        $playlist = $this->getPlaylist();
        return Inertia::render('AdagigPages/AdaPlaylist', [
            'playlist' => $playlist
        ]);
    }

    public function getToken()
    {

        $clientId = env('SPOTIFY_CLIENT_ID');
        $clientSecret = env('SPOTIFY_CLIENT_SECRET');
        $resource = Http::asForm()->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $clientId,
            'client_secret' => $clientSecret
        ]);

        if ($resource->successful()) {
            $accessToken = $resource->json('access_token');
            return $accessToken;
        }
        return response()->json(['error' => 'Failed to retrieve access token'], $resource->status());
    }

    public function getPlaylist()
    {
        $accessToken = $this->getToken();

        $playlistId = '0JnTYbRFXcWcz8EE41TsCq';

        $resource = Http::withToken($accessToken)
            ->get("https://api.spotify.com/v1/playlists/{$playlistId}/tracks");

        if ($resource->successful()) {
            return $resource->json();
        }

        return response()->json(['error' => 'Failed to retrieve playlist'], $resource->status());
    }
}
