<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use \Illuminate\Database\Eloquent\SoftDeletes;
class DateLockDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'week_dates',
        'created_by',
        'updated_by',
    ];
}
