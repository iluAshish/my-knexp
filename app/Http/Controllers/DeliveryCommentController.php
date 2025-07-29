<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Enums\ShipmentStatusEnum;
use App\Mail\GeneralMail;
use App\Models\DeliveryComment;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DeliveryCommentController extends Controller
{
    public function list()
    {
        return view('content.delivery-comments.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = [
            1 => 'orders.created_at',
            'orders.order_number',
            'customers.first_name',
            'customers.email as customer_email',
            'customers.phone as customer_phone',
            'orders.shipment_date',
            'orders.status',
            'orders.items',
            'branches.name as origin',
            'states.name as destination',
            'orders.name as from',
            'users.first_name as u_first_name',
            'orders.id',
            'orders.updated_at',
            'customer_id',
            'customers.last_name',
            'branches.branch_code',
            'users.last_name as u_last_name',
            'delivery_comments.comments',
            'delivery_comments.updated_by',
            'u2.first_name as c_first_name',
            'u2.last_name as c_last_name',
        ];


        $query = Order::select($columns)
            ->join('users', 'orders.updated_by', '=', 'users.id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->join('branches', 'orders.origin', '=', 'branches.id')
            ->leftJoin('delivery_comments', 'orders.id', '=', 'delivery_comments.order_id')
            ->leftJoin('users as u2', 'delivery_comments.user_id', '=', 'u2.id')
            ->join('states', 'orders.destination', '=', 'states.id');

        $query->where(function ($query) {
            $query->orWhere('orders.status', ShipmentStatusEnum::OUT_FOR_DELIVERY);
            $query->orWhere('orders.status', ShipmentStatusEnum::DELIVERED);
        });

        $user = auth()->user();
        if (isset($user->roles[0]->id) && in_array($user->roles[0]->id, [RoleEnum::ADMIN, RoleEnum::BRANCHMANAGER])) {
            $query->where('orders.origin', $user->branches[0]->id);
        }

        $totalData = $query->count();

        $start = $request->input('start');

        // Apply search filters
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($query) use ($search, $columns) {
                foreach ($columns as $column) {
                    $column = (string) Str::of($column)->before(' ');
                    $query->orWhere($column, 'like', "%{$search}%");
                }
            });
        }

        // Total filtered records
        $totalFiltered = $query->count();

        // Order and pagination
        $order = (string) Str::of($columns[$request->input('order.0.column')])->before(' ');
        $dir = $request->input('order.0.dir');
        $query->offset($start)
            ->limit($request->input('length'))
            ->orderBy($order, $dir);


        $data = [];

        if (!empty($query)) {
            // providing a dummy id instead of database ids
            $ids = $start;

            foreach ($query->get() as $record) {
                $nestedData['id'] = $record->id;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['order_number'] = $record->order_number;
                $nestedData['shipment_date'] = $record->shipment_date;
                $nestedData['status'] = $record->status;
                $nestedData['updated_by'] = $record->u_first_name . ' ' . $record->u_last_name;

                $nestedData['origin'] = $record->origin . ' (' . $record->branch_code . ')';
                $nestedData['destination'] = $record->destination;

                // Customer
                $nestedData['customer_id'] = $record->customer_id;
                $nestedData['first_name'] = $record->first_name . ' ' . $record->last_name;
                $nestedData['customer_email'] = $record->customer_email;
                $nestedData['customer_phone'] = $record->customer_phone;

                // Delivery Comments
                $nestedData['comments'] = isset($record->comments) ? $record->comments : '-' ;
                $nestedData['comment_by'] = isset($record->c_first_name) ? $record->c_first_name . ' ' . $record->c_last_name : '-';

                $data[] = $nestedData;
            }
        }

        if ($data) {
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'code' => 200,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
                'data' => [],
            ]);
        }
    }

    public function updateShipmentStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            //'order_status' => 'required',
            'comments' => 'nullable|string',
        ]);

        try {

            DB::beginTransaction();

            // $orderStatus = $request->input('order_status');
            $orderStatus = ShipmentStatusEnum::DELIVERED;

            $order = Order::findOrFail($request->input('order_id'));
            $order->update([
                'status' => $orderStatus,
            ]);

            Shipment::create([
                'order_id' => $order->id,
                'status' => $orderStatus,
            ]);

            DeliveryComment::create([
                'user_id' => auth()->user()->id,
                'status' => $orderStatus,
                'order_id' => $order->id,
                'comments' => $request->input('comments'),
            ]);

            $customer = $order->customer;
            $destination = $order->destinationState;

            $notificationData = [
                "branch_id" => $order->origin,
                "title" => "Shipment Updated",
                "description" => "Order# $order->order_number ($orderStatus) status has been updated by " . auth()->user()->first_name,
                "menu" => "Delivery Comments",
            ];
            Notification::createDeliveryNotification($notificationData);

            $details['name'] = $customer->first_name;
            $details['subject'] = "Delivery Update";
            $details['email'] = $customer->email;
            $details['message'] = "Your shipment status has been updated to $order->status<br><br>
                Tracking ID: $order->order_number (you can track from our website <a href='" . url("/") . "'>click here</a>) <br>
                Order Items: $order->items <br>
                Shipment Date: $order->shipment_date <br>
                Destination: $destination->name";

            Mail::send(new GeneralMail($details));

            DB::commit();
            return redirect()->back()->with(["status" => true, "message" => "Record updated successfully..!"]);
        } catch (\Exception $e) {
            DB::rollBack();
            info($e->getMessage());
            return redirect()->back()->with(["status" => false, "message" => "Record not updated. Please try again later..!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryComment $deliveryComment)
    {
        //
    }
}
