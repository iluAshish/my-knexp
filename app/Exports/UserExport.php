<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $users = User::select([
            'users.id',
            'users.first_name',
            'users.last_name',
            'users.email',
            'users.phone',
            'users.status',
            'created_users.first_name as created_by_first_name',
            'created_users.last_name as created_by_last_name',
            'users.created_at',
            'branches.name as branch_name',
            'roles.name as role_name',
        ])
            ->join('branch_users', 'users.id', '=', 'branch_users.user_id')
            ->join('branches', 'branch_users.branch_id', '=', 'branches.id')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->join('users as created_users', 'users.created_by', '=', 'created_users.id')
            ->get();

        return $users->map(fn($user) => [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'status' => ($user->status) ? 'Active' : 'Inactive',
            'created_by' => $user->created_by_first_name . ' ' . $user->created_by_last_name,
            'created_at' => $user->created_at,
            'branch_name' => $user->branch_name,
            'role_name' => $user->role_name,
        ]);
    }

    public function headings(): array
    {
        return [
            'Id',
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Status',
            'Created By',
            'Created At',
            'Branch Name',
            'Role Name',
        ];
    }
}
