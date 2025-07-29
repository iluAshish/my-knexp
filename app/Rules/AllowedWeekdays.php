<?php

namespace App\Rules;

use App\Models\DateLockWeek;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class AllowedWeekdays implements Rule
{
    public function passes($attribute, $value)
    {
        $allowedWeekdaysMap = DateLockWeek::get()->pluck('week_days')->flatten()->toArray();

        $selectedDay = Carbon::parse($value)->dayOfWeek;

        return in_array($selectedDay, $allowedWeekdaysMap);
    }

    public function message()
    {
        return 'The selected shipment date must be on an allowed weekday.';
    }
}
