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
    protected $description = 'Рассписание пар на завтра' . "\xF0\x9F\x93\x85";

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $tomorrow = Carbon::tomorrow();

        $day_number = DateHelper::formatDate($tomorrow, 'w');

        $lessons = Schedule::getTomorrowLessons();

        if ($day_number == 6 || $day_number == 0) {
            $response = 'Завтра пар нет';
            $trigger = 'nextweek';
        } elseif ($lessons->isEmpty()) {
            $response = 'Завтра пар нет';
            $trigger = 'week';
        } else {
           $response =  Schedule::getFormattedLessons($lessons, $day_number);
        }

        $this->replyWithMessage(['text' => $response, 'parse_mode' => 'HTML']);
        if (isset($trigger))
            $this->triggerCommand($trigger);
    }
}
