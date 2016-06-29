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

        $tracks = $this->musicxmatch->find($text);

        return $this->telegram
            ->setAsyncRequest(true)
            ->sendMessage([
                'chat_id' => $chat->getId(),
                'text' => "There are {$tracks->count()} results.",
            ]);
    }
}