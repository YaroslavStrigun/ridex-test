<?php

namespace App\Http\Commands;


class HelpCommand extends \Telegram\Bot\Commands\HelpCommand
{
    protected $description = 'Список комманд' . "\xE2\x9D\x93";

}
