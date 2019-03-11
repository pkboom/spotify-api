<?php

namespace Pkboom\SpotifyApis;

use Zttp\Zttp;

class SpotifyApis
{
    public static function login()
    {
        $redirect_uri = config('spotifyapis.redirect_uri');
        $client_id = config('spotifyapis.client_id');
        $scope = config('spotifyapis.scope');

        session(['spotify_state_key' => $state = sha1(config('spotifyapis.state'))]);

        header('Location: ' . "https://accounts.spotify.com/authorize?response_type=code&client_id={$client_id}&scope={$scope}&redirect_uri={$redirect_uri}&state={$state}");
    }

    public static function callback()
    {
        $client_id = config('spotifyapis.client_id');
        $client_secret = config('spotifyapis.client_secret');
        $state = request('state');

        if (is_null($state) || $state != session()->pull('spotify_state_key')) {
            throw new \Exception('Spitify API Error: state_mismatch');
        }

        $response = Zttp::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($client_id . ':' . $client_secret),
        ])
        ->asFormParams()
        ->post('https://accounts.spotify.com/api/token', [
            'code' => request('code'),
            'redirect_uri' => config('spotifyapis.redirect_uri'),
            'grant_type' => 'authorization_code'
        ]);
    
        if (!$response->isOk()) {
            throw new \Exception('Spitify API Error: ' . $response->body());
        }

        session(['spotify_access_token' => $response->json()['access_token']]);
        session(['spotify_refresh_token' => $response->json()['refresh_token']]);
    }

    public static function refreshToken()
    {
        $client_id = config('spotifyapis.client_id');
        $client_secret = config('spotifyapis.client_secret');

        $response = Zttp::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($client_id . ':' . $client_secret),
        ])->asFormParams()
        ->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => session('spotify_refresh_token')
        ]);

        if (!$response->isOk()) {
            throw new \Exception('Spitify API Error: ' . $response->body());
        }

        session(['spotify_access_token' => $response->json()['access_token']]);
    }

    public static function getArtist($artist)
    {
        $params = [ 'ids' => $artist ];

        return static::getInfo('artists', $params);
    }
    
    public static function getMe()
    {
        return static::getInfo('me');
    }

    public static function search($search, $type)
    {
        $params = [
            'q' => $search,
            'type' => $type // type=album,track ...
         ];
        
        return static::getInfo('search', $params);
    }

    protected static function getInfo($key, $parmas = null)
    {
        return Zttp::withHeaders([
            'Authorization' => 'Bearer ' . session('spotify_access_token'),
        ])->get("https://api.spotify.com/v1/{$key}", $parmas);
    }
}
