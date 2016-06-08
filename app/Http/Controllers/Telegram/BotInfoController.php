<?php

namespace App\Http\Controllers\Telegram;

class BotInfoController extends AbstractTelegramController
{
    public function index()
    {
        return $this->telegram->getMe();
    }
}