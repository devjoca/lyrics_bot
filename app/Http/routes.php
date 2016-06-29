<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', 'Telegram\BotInfoController@index');
$app->get('/set-webhook', 'Telegram\WebhookController@create');
$app->get('/test', function () {
    $musicxmatch = new App\LyricsFinder\MusicxmatchProvider;
    $tracks = $musicxmatch->find('adult');

    $keyboard = $tracks->take(3)->map(function ($track) {
        return [$track['track_name'].' - '.$track['artist_name']];
    });

    return $keyboard;
});
$app->post('/webhook', 'Telegram\ResponseController@create');