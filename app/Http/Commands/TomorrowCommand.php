<?php

namespace App\Http\Commands;

use App\Helpers\DateHelper;
use App\Models\Schedule;
use Carbon\Carbon;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class TomorrowCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'tomorrow';


    /**
     * @var string Command Description
     */
    protected $description = 'Рассписание пар на завтра.';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $tomorrow = Carbon::tomorrow();

        $day_number = DateHelper::formatDate($tomorrow, 'w');

        $lessons = Schedule::tomorrow();

        if ($day_number == 6 || $day_number == 5) {
            $response = 'Завтра пар нет';
            $trigger = 'nextweek';
        } elseif ($lessons->isEmpty()) {
            $response = 'Завтра пар нет';
            $trigger = 'week';
        } else {

            $response = '<b>' . DateHelper::MAP_WEEK_DAYS_NAME[$day_number] . '</b>' . ":\r\n";

            foreach ($lessons as $lesson) {
                $response .= sprintf('%s (%s - %s)' . PHP_EOL, '<i>' . $lesson->lesson . '</i>', $lesson->start, $lesson->end);
            }

        }

        $this->replyWithMessage(['text' => $response, 'parse_mode' => 'HTML']);
        if (isset($trigger))
            $this->triggerCommand($trigger);
    }
}
