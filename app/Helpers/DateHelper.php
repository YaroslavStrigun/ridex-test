<?php

namespace App\Helpers;


use Carbon\Carbon;

abstract class DateHelper
{
    const START_DATE = '01-09-2018';
    const MAP_WEEK_DAYS_NAME = [
        0 => 'Воскресение',
        1 => 'Понедельник',
        2 => 'Вторник',
        3 => 'Среда',
        4 => 'Четверг',
        5 => 'Пятница',
        6 => 'Суббота'
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

}
