<?php

namespace App\Http\Controllers;

use App\Enums\ShipmentStatusEnum;
use App\Models\DateLockDate;
use App\Models\DateLockWeek;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Shipment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShipmentController extends Controller
{
    public function list()
    {
        $dateLockWeeks = DateLockWeek::get()->pluck('week_days');
        $dateLockDays = DateLockDate::get()->pluck('week_dates');

        return view('content.shipments.index', compact('dateLockWeeks','dateLockDays'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = [
            1 => 'shipments.created_at',
            'orders.order_number',
            'orders.shipment_date',
            'shipments.status',
            'shipments.created_at',
            'shipments.order_id',
            'shipments.id',
        ];


        $query = Shipment::select($columns)
            ->join('orders', 'shipments.order_id', '=', 'orders.id');

        $user = auth()->user();
        if (isset($user->branches[0]->id)) {
            $query->where('orders.origin', $user->branches[0]->id);
        }

        $totalData = $query->count();

        $start = $request->input('start');

        // Apply search filters
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($query) use ($search, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', "%{$search}%");
                }
            });
        }

        // Status filter
        if ($request->input('status')) {
            $query->where('shipments.status', $request->input('status'));
        }
        // Shipment Date filter
        if ($request->input('shipment_date')) {
            $shipmentDate = Carbon::parse($request->input('shipment_date'))->toDateString();
            $query->whereDate('orders.shipment_date', '=', $shipmentDate);
        }

        // Total filtered records
        $totalFiltered = $query->count();

        // Order and pagination
        $order = $columns[$request->input('order.0.column')];
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
                $nestedData['order_id'] = $record->order_id;
                $nestedData['created_at'] = Carbon::parse($record->created_at)->timezone('Asia/Dubai')->format('d-m-Y H:i');

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

    public function bulkDelete(Request $request)
    {
        $request->validate(['shipment_ids' => 'required']);

        try {
            DB::beginTransaction();

            $ids = array_filter($request->input('shipment_ids'));

            $shipmentsToDelete = Shipment::where('status', ShipmentStatusEnum::DELIVERED)
                ->whereIn('id', $ids)
                ->get();

            if ($shipmentsToDelete->count()) {
                foreach ($shipmentsToDelete as $shipment) {
                    $shipment->order->deliveryComments()->delete();
                }
            }

            $orderIds = DB::table('shipments')->whereIn('id', $ids)
                ->get()
                ->pluck('order_id')
                ->toArray();

            $recordsDeleted = DB::table('shipments')->whereIn('id', $ids)->delete();

            $lastStatuses = Shipment::whereIn('order_id', $orderIds)
                ->get();

            foreach ($lastStatuses as $lastStatus) {
                $order = Order::find($lastStatus->order_id);

                $lastOrderStatus = Shipment::where('order_id', $lastStatus->order_id)
                    ->latest()
                    ->first();

                if ($order) {
                    $order->update(['status' => $lastOrderStatus->status]);

                    $notificationData = [
                        "branch_id" => $order->origin,
                        "title" => "Shipment Status Deleted",
                        "description" => "Order# $order->order_number ($lastOrderStatus->status) status has been deleted by " . auth()->user()->first_name,
                        "menu" => "Shipments",
                    ];
                    Notification::createNotification($notificationData);
                }
            }

            DB::commit();
            return response()->json(["status" => true, "message" => "$recordsDeleted Records deleted successfully..!"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            info($e->getMessage());
            return response()->json(["status" => false, "message" => "Records not deleted. Please try again later..!"], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipment $shipment)
    {
        try {

            DB::beginTransaction();

            $order = Order::where('id', $shipment->order_id)->first();

            if (!$order) {
                return response()->json(["status" => false, "message" => "Order not found."]);
            }

            $shipmentStatus = $shipment->status;

            $shipment->delete();

            if ($shipmentStatus === ShipmentStatusEnum::DELIVERED) {
                $order->deliveryComments()->delete();
            }

            $lastStatus = Shipment::where('order_id', $shipment->order_id)
                ->latest()
                ->first();

            $order->update(['status' => $lastStatus ? $lastStatus->status : ShipmentStatusEnum::RECEIVED]);

            $notificationData = [
                "branch_id" => $order->origin,
                "title" => "Shipment Status Deleted",
                "description" => "Order# $order->order_number ($shipmentStatus) status has been deleted by " . auth()->user()->first_name,
                "menu" => "Shipments",
            ];
            Notification::createNotification($notificationData);

            DB::commit();
            return response()->json(["status" => true, "message" => "Record deleted successfully..!"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            info($e->getMessage());
            return response()->json(["status" => false, "message" => "Record not deleted. Please try again later..!"], 500);
        }
    }
}
