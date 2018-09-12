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
        $now = Carbon::now();
        $lesson  = $today_lessons->where('start' , '<', $now->format('H:i:s'))->where('end', '>', $now->format('H:i:s') )->first();

        if (is_null($lesson))
            $response = 'Что-то не могу подсчитать. Сейчас точно пара?';
        else
            $response = "До конца пары осталось: " . '<b>' . ($now)->diff(new Carbon($lesson->end))->format('%I мин %S сек') . '</b>';

        $this->replyWithMessage(['text' => $response, 'parse_mode' => 'HTML']);


    }
}
