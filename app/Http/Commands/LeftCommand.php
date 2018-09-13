<?php

namespace App\Http\Commands;

use App\Helpers\DateHelper;
use App\Models\Schedule;
use Carbon\Carbon;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class LeftCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'left';


    /**
     * @var string Command Description
     */
    protected $description = 'Показывает время до конца пары' . "\xF0\x9F\x98\xA9";

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $today_lessons = Schedule::today();
        $now = Carbon::now()->timezone("Europe/Kiev")->format('H:i:s');
        $lesson  = $today_lessons->where('start' , '<', $now)->where('end', '>', $now)->first();

        if (is_null($lesson))
            $response = 'Что-то не могу подсчитать. Сейчас точно пара?';
        else
            $response = "До конца пары осталось: " . '<b>' . date('i мин s сек', strtotime($lesson->end) - strtotime($now)) . '</b>';

        $this->replyWithMessage(['text' => $response, 'parse_mode' => 'HTML']);


    }
}
