<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $customers = Customer::select([
            'customers.id',
            'customers.first_name',
            'customers.last_name',
            'customers.email',
            'customers.phone',
            'customers.address',
            'customers.created_by',
            'customers.created_at',
            'users.first_name as created_by_first_name',
            'users.last_name as created_by_last_name',
        ])
            ->leftJoin('users', 'customers.created_by', '=', 'users.id')
            ->get();

        return $customers->map(function ($customer) {
            return [
                'id' => $customer->id,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'address' => $customer->address,
                'created_by' => $customer->created_by_first_name . ' ' . $customer->created_by_last_name,
                'created_at' => $customer->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Id',
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Address',
            'Created By',
            'Created At',
        ];
    }
}
