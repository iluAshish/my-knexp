<?php

namespace App\Exports;

use App\Models\Notification;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NotificationExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $notifications = Notification::select([
            'notifications.id',
            'users.first_name',
            'users.last_name',
            'notifications.title',
            'notifications.description',
            'notifications.menu',
            'u2.first_name as createdByFirstName',
            'u2.last_name as createdByLastName',
            'notifications.created_by',
            'notifications.created_at',
            'notifications.read_at',
        ])
            ->join('users', 'notifications.user_id', '=', 'users.id')
            ->join('users as u2', 'notifications.created_by', '=', 'u2.id')
            ->get();

        return $notifications->map(fn($notification) => [
            'id' => $notification->id,
            'first_name' => $notification->first_name . ' ' . $notification->last_name,
            'title' => $notification->title,
            'description' => $notification->description,
            'menu' => $notification->menu,
            'created_by' => $notification->createdByFirstName . ' ' . $notification->createdByLastName,
            'read_at' => $notification->read_at,
            'created_at' => $notification->created_at,
        ]);
    }

    public function headings(): array
    {
        return [
            'Id',
            'Notification For',
            'Title',
            'Description',
            'Menu',
            'Created By',
            'Read At',
            'Created At',
        ];
    }
}
