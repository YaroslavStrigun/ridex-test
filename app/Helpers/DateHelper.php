<?php

namespace App\Helpers;


use Carbon\Carbon;

abstract class DateHelper
{
    const START_DATE = '01-09-2018';
    const MAP_WEEK_DAYS_NAME = [
        0 => "Воскресение",
        1 => "Понедельник \xF0\x9F\x98\xAD",
        2 => "Вторник \xF0\x9F\x98\xB0",
        3 => "Среда \xF0\x9F\x98\xA9",
        4 => "Четверг \xF0\x9F\x8D\xBA",
        5 => "Пятница \xF0\x9F\x8D\xBB",
        6 => "Суббота"
    ];

    static public function formatDate($date = null, $format = 'd-m-Y')
    {
        $date = $date ?? Carbon::now();
        $format_date =  date($format, strtotime($date));

        return $format_date;
    }

    static public function weekNumber($date = null)
    {
        $date = $date ?? Carbon::now();
        $week_number = self::formatDate($date, 'W');

        if ($week_number % 2 == 0)
            $week_number = 1;
        else
            $week_number = 2;

        return $week_number;

    }

    static public function nextWeekNumber()
    {
        $current_week = self::weekNumber();

        return $current_week == 1 ? 2 : 1;
    }

}
