<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'menu',
        'created_by',
    ];

    /**
     * Define the relationship with the user (Many-to-One).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function u2()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getUserNameAttribute()
    {
        return $this->user->first_name . ' ' . $this->user->last_name;
    }

    /**
     * Define the relationship with the creator (Many-to-One).
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getCreatedByNameAttribute()
    {
        return $this->createdBy->first_name . ' ' . $this->createdBy->last_name;
    }

    public static function createNotification($data): bool
    {
        $user = Auth::user();

        // Create notifications for Super Admins
        User::doesntHave('roles')->each(function ($superAdmin) use ($data, $user) {
            self::create([
                'user_id'     => $superAdmin->id,
                'title'       => $data['title'],
                'description' => $data['description'],
                'menu'        => $data['menu'],
                'created_by'  => $user->id,
            ]);
        });

        // Create notifications for branch-related Admins and Branch Managers
        $branchUsers = DB::table('branch_users')
            ->where('branch_id', $data['branch_id'])
            ->whereIn('role_id', [2, 3])
            ->join('users', 'users.id', '=', 'branch_users.user_id')
            ->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->pluck('users.id')
            ->toArray();

        foreach ($branchUsers as $userId) {
            self::create([
                'user_id'     => $userId,
                'title'       => $data['title'],
                'description' => $data['description'],
                'menu'        => $data['menu'],
                'created_by'  => $user->id,
            ]);
        }

        return true;
    }

    public static function createDeliveryNotification($data): void
    {
        self::createNotification($data);
        $user = Auth::user();
        if (isset($user->roles[0]->id) && $user->roles[0]->id == RoleEnum::DELIVERYAGENT) {
            self::create([
                'user_id'     => $user->id,
                'title'       => $data['title'],
                'description' => $data['description'],
                'menu'        => $data['menu'],
                'created_by'  => $user->id,
            ]);
        }
    }

    public static function createNotificationForDeliveryAgents($data): void
    {
        $user = Auth::user();

        $deliveryAgents = DB::table('role_user')->where('role_id', RoleEnum::DELIVERYAGENT)
            ->get()
            ->pluck('user_id')
            ->toArray();

        foreach ($deliveryAgents as $deliveryAgentId) {
            self::create([
                'user_id'     => $deliveryAgentId,
                'title'       => $data['title'],
                'description' => $data['description'],
                'menu'        => $data['menu'],
                'created_by'  => $user->id,
            ]);
        }
    }

}
