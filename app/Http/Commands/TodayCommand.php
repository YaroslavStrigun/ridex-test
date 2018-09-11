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

        $lessons = Schedule::today();

        $response = DateHelper::MAP_WEEK_DAYS_NAME[DateHelper::formatDate(null, 'w')] .":\r\n";

        foreach ($lessons as $lesson) {
            $response .= sprintf('%s (%s - %s)' . PHP_EOL, $lesson->lesson, $lesson->start, $lesson->end);
        }

        $this->replyWithMessage(['text' => $response]);
    }
}
