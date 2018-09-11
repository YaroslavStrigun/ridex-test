<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
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

    public static function today()
    {
        return self::byDay(null);

    }

    public static function tomorrow()
    {
        $tomorrow = Carbon::tomorrow();

        return self::byDay($tomorrow);

    }

    public static function byDay($day = null)
    {
        return self::where('week', $week ?? DateHelper::weekNumber($day))
            ->where('day', DateHelper::formatDate($day, 'w'))
            ->orderBy('start')
            ->get();
    }

}
