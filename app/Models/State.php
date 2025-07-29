<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'destination');
    }
}
