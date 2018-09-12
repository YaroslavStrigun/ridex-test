<?php

namespace App\Http\Commands;

use App\Helpers\DateHelper;
use App\Models\Schedule;
use Carbon\Carbon;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class WhoCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'who';


    /**
     * @var string Command Description
     */
    protected $description = 'Подсказывает имя преподавателя' . "\xF0\x9F\x91\xB4";

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $today_lessons = Schedule::today();
        $now = Carbon::now();
        $lesson  = $today_lessons->where('start' , '<', $now->format('H:i:s'))->where('end', '>', $now->format('H:i:s') )->first();

        if (is_null($lesson))
            $response = 'Сейчас точно пара?';
        else
            $response = $lesson->teacher ?? "Я не знаю как зовут этого преподавателя.";

        $this->replyWithMessage(['text' => $response, 'parse_mode' => 'HTML']);

    }
}
