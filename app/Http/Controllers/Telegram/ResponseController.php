<?php

namespace App\Http\Controllers\Telegram;

class ResponseController extends AbstractTelegramController
{
    public function create()
    {
        $update = $this->telegram->getWebhookUpdates();
        $message = $update->getMessage();
        $chat = $message->getChat();

        return $this->telegram->sendMessage([
          'chat_id' => $chat->getId(),
          'text' => 'hola bb'
        ]);
    }
}