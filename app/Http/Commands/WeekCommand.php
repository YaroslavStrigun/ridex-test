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
        $this->week_number = DateHelper::getWeekNumber();
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

        $lessons = Schedule::getLessonsByWeek()->groupBy('day');

        $response = "<b>$this->week_number неделя</b>" . ":\r\n";
        $response .= "-----------\n";

        foreach ($lessons as $day_number => $day_lessons) {
            $response .= Schedule::getFormattedLessons($day_lessons, $day_number);
            $response .= "-----------\n";
        }

        $this->replyWithMessage(['text' => $response, 'parse_mode' => 'HTML']);
    }
}
