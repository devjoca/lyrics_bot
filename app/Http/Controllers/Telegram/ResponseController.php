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

        $this->telegram->setAsyncRequest(true)->sendMessage([
            'chat_id' => $chat->getId(),
            'text' => "This bot was powered by Musicxmatch",
        ]);

        $tracks = $this->musicxmatch->find($text);

        $message = $this->prepareMessage($chat, $tracks);

        return $this->telegram
                    ->setAsyncRequest(true)
                    ->sendMessage($message);
    }

    protected function prepareMessage($chat, $tracks)
    {
        $message = [
            'chat_id' => $chat->getId(),
            'text' => "There are {$tracks->count()} results.`",
            'reply_markup' => $this->prepareReplyMarkup($tracks),
        ];

        return $message;
    }

    protected function prepareReplyMarkup($tracks)
    {
        if ($tracks->isEmpty()) return $this->telegram->replyKeyboardHide();

        $keyboard = $tracks->take(5)->map(function ($track) {
            return ['id:'.$track['track_id'].' - '.$track['track_name'].' - '.$track['artist_name']];
        });

        return $this->telegram->replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);
    }
}