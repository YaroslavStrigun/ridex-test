<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    const SCHEDULE_WORDS = ['розклад', 'расписание'];

    protected $guarded = [];

    public $timestamps = false;

    public function getStartAttribute($value)
    {
        return DateHelper::formatDate($value, 'H:i');
    }

    public function getEndAttribute($value)
    {
        return DateHelper::formatDate($value, 'H:i');
    }

    public static function getTodayLessons()
    {
        return self::getLessonsByDay(null);

    }

    public static function getTomorrowLessons()
    {
        $tomorrow = Carbon::tomorrow()->timezone("Europe/Kiev");

        return self::getLessonsByDay($tomorrow);

    }

    public static function getLessonsByDay($day = null)
    {
        return self::where('week', $week ?? DateHelper::getWeekNumber($day))
            ->where('day', DateHelper::formatDate($day, 'w'))
            ->orderBy('start')
            ->get();
    }

    public static function getLessonsByWeek($week = null)
    {
        $week = is_null($week) ?? DateHelper::getWeekNumber();

        return self::where('week', $week)
            ->orderBy('day')
            ->get();
    }

    public static function getFormattedLessons($lessons = [], $day_number)
    {
        $response = '<b>' . DateHelper::MAP_WEEK_DAYS_NAME[$day_number] . '</b>' . ":\r\n";

        foreach ($lessons->sortBy('start') as $lesson) {
            $response .= sprintf('%s (%s - %s)' . PHP_EOL, '<i>' . $lesson->lesson . '</i>', $lesson->start, $lesson->end);
        }

        return $response;

    }

}
