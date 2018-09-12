<?php

namespace App\Http\Commands;


use App\Helpers\DateHelper;

class NextWeekCommand extends WeekCommand
{
    protected $name = 'nextweek';

    public function __construct()
    {
        $this->week_number = DateHelper::nextWeekNumber();
    }


    protected $description = 'Рассписание пар на следующую неделю.';

}
