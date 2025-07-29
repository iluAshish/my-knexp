<?php

namespace App\Rules;

use App\Models\DateLockDate;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class NotInDateLockDays implements Rule
{
    public function passes($attribute, $value)
    {
        $dateLockDays = DateLockDate::get()->pluck('week_dates')->flatten()->unique();
        $value = Carbon::parse($value)->toDateString();
        return !in_array($value, $dateLockDays->toArray());
    }

    public function message()
    {
        return 'The selected shipment date is not allowed.';
    }
}
