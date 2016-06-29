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

        $reply_markup = $this->prepareReplyMarkup($tracks);

        return $this->telegram
            ->setAsyncRequest(true)
            ->sendMessage([
                'chat_id' => $chat->getId(),
                'text' => "There are {$tracks->count()} results.`",
                'reply_markup' => $reply_markup,
            ]);
    }

    public function prepareReplyMarkup($tracks)
    {
        $keyboard = ['Holi', 'More'];

        return $this->telegram->replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);
    }
}