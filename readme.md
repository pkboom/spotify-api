# Spotify API

## Installation
```bash
composer require pkboom/spotify-apis
```

Create shopify [client id](https://developer.spotify.com/dashboard/)

Go to 'EDIT SETTING' -> Register Redirect URIs

Publish config-file and set it up
``` php
php artisan vendor:publish --provider="Pkboom\SpotifyApis\SpotifyApisServiceProvider"
```
Create a callback route
```php
// Example
Route::get('callback', function() {
    SpotifyApis::callback();
});
```

## Usage
```php
// Controller
use Pkboom\SpotifyApis;

class SpotifyApisController extends Controller
{
    public function login()
    {
        SpotifyApis::login();
    }
    
    public function callback()
    {
        SpotifyApis::callback();
    }

    public function refreshToken()
    {
        SpotifyApis::refreshToken();
    }
    
    public function getArtist($artist)
    {
        return SpotifyApis::getArtist($artist);
    }

    public function getMe()
    {
        return SpotifyApis::getMe();
    }

    public function search()
    {
        return SpotifyApis::search('bts', 'artist');
    }

// Route
Route::get('spotify/login', 'SpotifyApisController@login');
Route::get('spotify/callback', 'SpotifyApisController@callback');
Route::get('spotify/refresh_token', 'SpotifyApisController@refreshToken');

Route::get('spotify/artists/{artist}', 'SpotifyApisController@getArtist');
Route::get('spotify/me', 'SpotifyApisController@getMe');
Route::get('spotify/search', 'SpotifyApisController@search');
```

You could easily extends the class to create new methods
```php
use Pkboom\SpotifyApis as Spotify;

class SpotifyApis extends Spotify
{
    public function getAlbum($album)
    {
        $params = [ 'ids' => $album ];

        return static::getInfo('albums', $params);
    }
}
```

[Spotify Web API](https://developer.spotify.com/documentation/web-api/)
## License

The MIT License (MIT). Please see [MIT license](http://opensource.org/licenses/MIT) for more information.