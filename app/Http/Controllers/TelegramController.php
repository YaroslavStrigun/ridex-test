<?php

namespace App\Http\Controllers;

use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Storage;
class TelegramController extends Controller
{

    public function webhook()
    {
        Telegram::commandsHandler(true);
    }

}
