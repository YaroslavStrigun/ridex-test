<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public static function today()
    {
       return self::where('week', DateHelper::weekNumber())
            ->where('day', DateHelper::formatDate(null, 'w'))
            ->orderBy('start')
            ->get();

    }

}
