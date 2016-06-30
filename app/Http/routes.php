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
    return $musicxmatch->find('Surfeando En La Arena Bajo El Sol a 34 Grados');
});
$app->post('/webhook', 'Telegram\ResponseController@create');