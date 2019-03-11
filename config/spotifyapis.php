<?php

return [
    'client_id' => env('SPOTIFY_TOKEN'),

    'client_secret' => env('SPOTIFY_SECRET'),

    // callback you registed for your spotify
    'redirect_uri' => 'http://your-domain.com/spotify/callback',

    // https://developer.spotify.com/documentation/general/guides/scopes/
    'scope' => 'user-read-private user-read-email',

    // Abitrary key for confirming your callback response
    'state' => 'state key',
];
