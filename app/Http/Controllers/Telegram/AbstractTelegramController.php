<?php

namespace App\Http\Controllers\Telegram;

use Telegram\Bot\Api;
use App\Http\Controllers\Controller as BaseController;

abstract class AbstractTelegramController extends BaseController
{
    protected $telegram;

    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_TOKEN'));
    }
}