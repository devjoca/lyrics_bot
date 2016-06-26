<?php

namespace App\Http\Controllers\Telegram;

use App\LyricsFinder\MusicxmatchProvider;

class ResponseController extends AbstractTelegramController
{
    protected $musicxmatch;

    public function __construct()
    {
        parent::__construct();
        $this->musicxmatch = new MusicxmatchProvider();
    }

    public function create()
    {
        $update = $this->telegram->getWebhookUpdates();
        $message = $update->getMessage();
        $chat = $message->getChat();
        $text = $message->getText();

        $r = $this->musicxmatch->find($text);
        $m = '';
        foreach($r['message']['body']['track_list'] as $t) {
            $m = "{$m} {$t['track']['track_name']} - {$t['track']['artist_name']}".PHP_EOL;
        }

        return $this->telegram->sendMessage([
          'chat_id' => $chat->getId(),
          'text' => $m,
        ]);
    }
}