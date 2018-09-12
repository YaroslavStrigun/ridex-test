<?php

namespace App\Http\Commands;

use App\Models\Schedule;
use Carbon\Carbon;
use CURLFile;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'start';


    /**
     * @var string Command Description
     */
    protected $description = 'start';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $response = 'Привет, я помогу тебе с рассписанием. Смотри ниже что я умею.';

        $this->replyWithMessage(['text' => $response]);
        $this->triggerCommand('help');

    }
}
