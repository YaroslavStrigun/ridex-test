<?php

namespace App\Http\Commands;


class HelpCommand extends \Telegram\Bot\Commands\HelpCommand
{
    protected $description = 'Список комманд' . "\xE2\x9D\x93";

    public function handle()
    {
        $commands = $this->telegram->getCommands();

        $text = '';
        foreach ($commands as $name => $handler) {
            if ($name == 'start')
                continue;

            $text .= sprintf('/%s - %s'.PHP_EOL, $name, $handler->getDescription());
        }

        $this->replyWithMessage(compact('text'));
    }

}
