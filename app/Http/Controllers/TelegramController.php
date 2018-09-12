<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{

    public function webhook()
    {
        $updates = json_decode(Telegram::getWebhookUpdates(), true);
        foreach (Schedule::SCHEDULE_WORDS as $word) {
            if (strpos (mb_strtolower($updates['message']['text']), $word) !== false) {
                $name = $updates['message']['from']['first_name'] ?? $updates['message']['from']['username'];
                Telegram::sendMessage([
                    'chat_id' => $updates['message']['chat']['id'],
                    'text' => $name . ', <b>я могу помочь</b>  ' . '/help' . chr(10),
                    'parse_mode' => 'html'
                ]);
            }
        }


        Telegram::commandsHandler(true);

    }

}
