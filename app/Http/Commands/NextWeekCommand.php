<?php

namespace App\Http\Commands;


use App\Helpers\DateHelper;

class NextWeekCommand extends WeekCommand
{
    protected $name = 'nextweek';

    public function __construct()
    {
        $this->week_number = DateHelper::getNextWeekNumber();
    }


    protected $description = 'Рассписание пар на следующую неделю.';

}
