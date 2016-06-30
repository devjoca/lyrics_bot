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
        try {
            $response = $this->http_client->get($this->getFindTracksUrl($search_text));
        } catch (Exception $e) {
            return;
        }

        $body = json_decode($response->getBody(), true);
        $tracks = [];
        foreach ($body['message']['body']['track_list'] as $t) {
            $tracks[] = $t['track'];
        }

        return collect($tracks);
    }

    public function getLyric($track_id)
    {
        try {
            $response = $this->http_client->get($this->getFindTracksUrl($search_text));
        } catch (Exception $e) {
            return;
        }
        $body = json_decode($response->getBody(), true);

        return $body['message']['body']['lyrics']['lyrics_body'];
    }

    protected function getLyricGetUrl($track_id)
    {
        $query = http_build_query(['track_id' => $track_id, 'apikey' => env('MUSICXMATCH_TOKEN')]);

        return "{$this->api_url}/track.lyrics?{$query}";
    }

    protected function getFindTracksUrl($search_text)
    {
        $query = http_build_query(['q_track' => $search_text, 'f_has_lyrics'=> 1, 's_artist_rating'=>'desc', 'apikey' => env('MUSICXMATCH_TOKEN')]);

        return "{$this->api_url}/track.search?{$query}";
    }


}