<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $orders = Order::select([
            'orders.id',
            'orders.order_number',
            'customers.first_name as customer_first_name',
            'customers.last_name as customer_last_name',
            'customers.email as customer_email',
            'customers.phone as customer_phone',
            'customers.address as customer_address',
            'orders.shipment_date',
            'orders.status',
            'orders.items',
            'branches.name as origin',
            'states.name as destination',
            'orders.name as sender_name',
            'orders.email as sender_email',
            'orders.phone as sender_phone',
            'orders.address as sender_address',
            'users.first_name as updated_by_first_name',
            'users.last_name as updated_by_last_name',
            'orders.created_at',
            'orders.updated_at',
        ])
            ->join('users', 'orders.updated_by', '=', 'users.id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->join('branches', 'orders.origin', '=', 'branches.id')
            ->join('states', 'orders.destination', '=', 'states.id')
            ->get();

        return $orders->map(fn($order) => [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'customer_name' => $order->customer_first_name . ' ' . $order->customer_last_name,
            'customer_email' => $order->customer_email,
            'customer_phone' => $order->customer_phone,
            'customer_address' => $order->customer_address,
            'shipment_date' => $order->shipment_date,
            'status' => $order->status,
            'items' => $order->items,
            'origin' => $order->origin,
            'destination' => $order->destination,
            'sender_name' => $order->sender_name,
            'sender_email' => $order->sender_email,
            'sender_phone' => $order->sender_phone,
            'sender_address' => $order->sender_address,
            'updated_by' => $order->updated_by_first_name . ' ' . $order->updated_by_last_name,
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
        ]);
    }

    public function headings(): array
    {
        return [
            'Id',
            'Order Number',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Customer Address',
            'Shipment Date',
            'Status',
            'Items',
            'Origin',
            'Destination',
            'Sender Name',
            'Sender Email',
            'Sender Phone',
            'Sender Address',
            'Updated By',
            'Created At',
            'Updated At',
        ];
    }
}
