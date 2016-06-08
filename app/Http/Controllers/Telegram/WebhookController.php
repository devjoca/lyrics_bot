<?php

namespace App\Http\Controllers\Telegram;

class WebhookController extends AbstractTelegramController
{
    public function create()
    {
        return $this->telegram->setWebhook(['url' => url('/webhook', [], true)]);
    }
}