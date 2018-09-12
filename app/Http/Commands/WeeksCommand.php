<?php

namespace App\Http\Commands;

use App\Helpers\DateHelper;
use App\Models\Schedule;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class WeeksCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'weeks';


    /**
     * @var string Command Description
     */
    protected $description = 'Рассписание пар на две недели.';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->triggerCommand('week');
        $this->triggerCommand('nextweek');
    }
}
