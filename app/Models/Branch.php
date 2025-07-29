<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'state_id',
        'name',
        'branch_code',
        'phone',
        'address',
        'status',
        'created_by',
        'updated_by',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'branch_users', 'branch_id', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'origin');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
