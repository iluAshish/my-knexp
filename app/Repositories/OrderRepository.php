<?php

namespace App\Repositories;

use App\Models\Branch;
use App\Models\Order;
use Carbon\Carbon;

class OrderRepository
{
    protected Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function createOrder(array $data, $customer_id)
    {
        $order = new Order([
            'order_number' => 'temp',
            'customer_id' => $customer_id,
            'shipment_date' => Carbon::parse($data['shipment_date'])->toDateString(),
            'items' => $data['items'],
            'origin' => $data['branch_id'],
            'destination' => $data['state_id'],
            'name' => $data['sender']['name'],
            'email' => $data['sender']['email'],
            'phone' => $data['sender']['phone'],
            'address' => $data['sender']['address'],
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
            'servicetype' => $data['servicetype'],
        ]);

        $order->save();
        $branch = Branch::find($data['branch_id']);
        $order->order_number = $branch->branch_code . str_pad($order->id, 5, '0', STR_PAD_LEFT);

        $order->save();

        return $order;
    }

    public function findOrderById($orderId)
    {
        return $this->order->find($orderId);
    }

    public function updateOrder($orderId, array $data)
    {
        $order = $this->findOrderById($orderId);

        if ($order) {
            $order->update($data);
        }

        return $order;
    }

    public function deleteOrder($orderId)
    {
        $order = $this->findOrderById($orderId);

        if ($order) {
            $order->delete();
        }

        return $order;
    }

    public function getAllOrders()
    {
        return $this->order->all();
    }
}