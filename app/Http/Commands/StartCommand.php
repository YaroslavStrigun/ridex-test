<?php

namespace App\Http\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\FileUpload\InputFile;

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
        $this->replyWithChatAction(['action' => Actions::UPLOAD_AUDIO]);

        $this->replyWithAudio([
            'audio' => new InputFile(asset('storage/start.mp3')),
            'title' => 'Привет',
            'performer' => 'Супер бот'
            ]);

        $this->triggerCommand('help');

    }
}
