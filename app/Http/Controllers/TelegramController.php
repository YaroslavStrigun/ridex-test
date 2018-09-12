<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{


    public function webhook()
    {
        $updates = json_decode(Telegram::getWebhookUpdates(), true);
        if (mb_strtolower($updates['message']['text']) == "лох") {
            Telegram::sendMessage([
                'chat_id' => $updates['message']['chat']['id'],
                'text' => '<b>Сам ти лох</b>',
                'parse_mode' => 'html'
            ]);
        }

        Telegram::commandsHandler(true);

    }

}
