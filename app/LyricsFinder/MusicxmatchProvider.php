<?php

namespace App\LyricsFinder;

use GuzzleHttp\Client;

class MusicxmatchProvider
{

    protected $api_url = 'http://api.musixmatch.com/ws/1.1';

    public function __construct()
    {
        $this->http_client = new Client;
    }

    public function find($search_text)
    {
        $find_tracks_url = $this->getFindTracksUrl($search_text);

        try {
            $response = $this->http_client->get($find_tracks_url);
        } catch (Exception $e) {
            return;
        }

        return json_decode($response->getBody(), true);
    }

    protected function getFindTracksUrl($search_text)
    {
        $query = http_build_query(['q_track' => $search_text, 'f_has_lyrics'=> 1, 'apikey' => env('MUSICXMATCH_TOKEN')]);

        return "{$this->api_url}/track.search?{$query}";
    }
}