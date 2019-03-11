<?php

namespace Pkboom\SpotifyApis;

use Illuminate\Support\ServiceProvider;

class SpotifyApisServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/spotifyapis.php' => config_path('spotifyapis.php'),
        ]);
    }
}
