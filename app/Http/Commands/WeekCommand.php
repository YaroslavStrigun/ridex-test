<?php

namespace App\Http\Commands;
use App\Helpers\DateHelper;
use App\Models\Schedule;
use Carbon\Carbon;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class WeekCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'week';

    protected $week_number;

    public function __construct()
    {
        $this->week_number = DateHelper::weekNumber();
    }


    /**
     * @var string Command Description
     */
    protected $description = 'Рассписание пар на эту неделю.';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $lessons = Schedule::byWeek()->groupBy('day');

        $response = "<b>$this->week_number неделя</b>" . ":\r\n";
        $response .= "-----------\n";
        foreach ($lessons as $day_number => $day_lessons) {
            $response .= "<b>" . DateHelper::MAP_WEEK_DAYS_NAME[$day_number] . "</b>" . ":\r\n";
            foreach ($day_lessons->sortBy('start') as $lesson) {
                $response .= sprintf('%s (%s - %s)' . PHP_EOL, '<i>' . $lesson->lesson . '</i>', $lesson->start, $lesson->end);
            }
            $response .= "-----------\n";

        }

        $this->replyWithMessage(['text' => $response, 'parse_mode' => 'HTML']);
    }
}
