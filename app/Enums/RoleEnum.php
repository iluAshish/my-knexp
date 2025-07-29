<?php

namespace App\Enums;

class RoleEnum
{
    const SUPERADMIN = 1;
    const ADMIN = 2;
    const BRANCHMANAGER = 3;
    const DELIVERYAGENT = 4;

    public static function all()
    {
        return [
            self::SUPERADMIN,
            self::ADMIN,
            self::BRANCHMANAGER,
            self::DELIVERYAGENT,
        ];
    }

    public static function toString($role)
    {
        return match ($role) {
            self::SUPERADMIN => 'Super Admin',
            self::ADMIN => 'Admin',
            self::BRANCHMANAGER => 'Branch Manager',
            self::DELIVERYAGENT => 'Delivery Agent',
            default => null,
        };
    }
}
