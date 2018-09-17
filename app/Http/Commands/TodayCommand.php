<?php

namespace App\Http\Commands;

use App\Helpers\DateHelper;
use App\Models\Schedule;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class TodayCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'today';


    /**
     * @var string Command Description
     */
    protected $description = 'Рассписание пар на сегодня' . "\xF0\x9F\x95\x90";

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $day_number = DateHelper::formatDate(null, 'w');

        $lessons = Schedule::getTodayLessons();

        if ($day_number == 6) {
            $response = 'Сегодня пар нет';
            $trigger = 'nextweek';
        } elseif ($day_number == 0) {
            $response = 'Сегодня пар нет';
            $trigger = 'tomorrow';
        } elseif ($lessons->isEmpty()) {
            $response = 'Сегодня пар нет';
            if (Schedule::tomorrow()->isNotEmpty())
                $trigger = 'tomorrow';
            else
                $trigger = 'week';
        } else {
            $response = Schedule::getFormattedLessons($lessons, $day_number);
        }

        $this->replyWithMessage(['text' => $response, 'parse_mode' => 'HTML']);
        if (isset($trigger))
            $this->triggerCommand($trigger);
    }
}

;
