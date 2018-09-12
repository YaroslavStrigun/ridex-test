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
    protected $description = 'Рассписание пар на сегодня.';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $day_number = DateHelper::formatDate(null, 'w');

        $lessons = Schedule::today();

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

            $response = '<b>' . DateHelper::MAP_WEEK_DAYS_NAME[DateHelper::formatDate(null, 'w')] . '</b>' . ":\r\n";

            foreach ($lessons as $lesson) {
                $response .= sprintf('%s (%s - %s)' . PHP_EOL, '<i>' . $lesson->lesson . '</i>', $lesson->start, $lesson->end);
            }

        }

        $this->replyWithMessage(['text' => $response, 'parse_mode' => 'HTML']);
        if (isset($trigger))
            $this->triggerCommand($trigger);
    }
}
