<?php

namespace App\Http\Controllers;

use App\Enums\ShipmentStatusEnum;
use App\Exports\OrderExport;
use App\Mail\GeneralMail;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\DateLockDate;
use App\Models\DateLockWeek;
use App\Models\Notification;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Shipment;
use App\Models\State;
use App\Repositories\CustomerRepository;
use App\Repositories\OrderRepository;
use App\Services\SmsGlobalService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    protected OrderRepository $orderRepository;
    protected CustomerRepository $customerRepository;

    public function __construct(OrderRepository $orderRepository, CustomerRepository $customerRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
    }

    public function list()
    {
        return view('content.orders.index');
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
            'branches.name as origin',
            'states.name as destination',
            'orders.shipment_date',
            'orders.status',
            'orders.items',
            'orders.name as from',
            'users.first_name as u_first_name',
            'orders.id',
            'orders.updated_at',
            'customer_id',
            'customers.last_name',
            'branches.branch_code',
            'users.last_name as u_last_name',
        ];


        $query = Order::select($columns)
            ->join('users', 'orders.updated_by', '=', 'users.id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->join('branches', 'orders.origin', '=', 'branches.id')
            ->join('states', 'orders.destination', '=', 'states.id');

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
                    $column = (string) Str::of($column)->before(' ');
                    $query->orWhere($column, 'like', "%$search%");
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

                $nestedData['origin'] = $record->origin;
                $nestedData['destination'] = $record->destination;

                // Customer
                $nestedData['customer_id'] = $record->customer_id;
                $nestedData['first_name'] = $record->first_name . ' ' . $record->last_name;
                $nestedData['customer_email'] = $record->customer_email;
                $nestedData['customer_phone'] = $record->customer_phone;

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


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dateLockWeeks = DateLockWeek::get()->pluck('week_days');
        $dateLockDays = DateLockDate::get()->pluck('week_dates');

        $customers = Customer::get();

        $branches = Branch::where('status', 1);
        $user = auth()->user();
        $isSuperAdmin = true;
        if (isset($user->roles[0]->name) && isset($user->branches[0]->id)) {
            $branches = $branches->where('id', $user->branches[0]->id);
            $isSuperAdmin = false;
        }
        $branches = $branches->get();

        $states = State::where('status', 1)
            ->where('country_id', 186)
            ->get();

        return view('content.orders.create', compact('customers', 'branches', 'states', 'dateLockWeeks', 'dateLockDays', 'isSuperAdmin'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        try {

            DB::beginTransaction();

            $customer = $this->customerRepository->firstOrCreate(['email' => $request->input('customer.email')], $request->input('customer'));
            $customer->created_by = auth()->user()->id;
            $customer->save();

            $order = $this->orderRepository->createOrder($request->input(), $customer->id);

            $branch = $order->originBranch;
            $destination = $order->destinationState;

            Shipment::create(['order_id' => $order->id]);

            $notificationData = [
                "branch_id" => $branch->id,
                "title" => "Order Created",
                "description" => "$order->order_number has been created by " . auth()->user()->first_name,
                "menu" => "Orders",
            ];

            Notification::createNotification($notificationData);

            $message = "Dear $customer->first_name,

$order->items package(s) received at $branch->name. Tracking ID is $order->order_number.

Track your shipment on www.knexpress.ae

You are lucky today";
            // SmsGlobalService::sendSms($customer, $message);
//             $message = "Your Shipment in successfully received 
            
// in $branch->name 

// on $order->created_at";

            SmsGlobalService::sendSms($customer, $message);


            $details['name'] = $customer->first_name . ' ' . $customer->last_name;
            $details['subject'] = 'Shipment Received';
            $details['email'] = $customer->email;
            $details['message'] = "Your shipment has been received by $branch->name on $order->created_at <br><br>
                Tracking ID: $order->order_number (you can track from our website <a href='" . url("/") . "'>click here</a>) <br>
                Order Items: $order->items <br>
                Shipment Date: $order->shipment_date <br>
                Destination: $destination->name <br>
                Service Types: $order->servicetype";

            Mail::send(new GeneralMail($details));

            DB::commit();
            return redirect()->route('order.list')->with(["status" => true, "message" => "Record added successfully..!"]);
        } catch (\Exception $e) {
            DB::rollBack();
            info($e->getMessage());
            return redirect()->back()->with(["status" => false, "message" => "Record not added. Please try again later..!"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('content.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $dateLockWeeks = DateLockWeek::get()->pluck('week_days');
        $dateLockDays = DateLockDate::get()->pluck('week_dates');

        $customers = Customer::get();
        $orderCustomer = Customer::find($order->customer_id);

        $branches = Branch::where('status', 1);
        $user = auth()->user();
        $isSuperAdmin = true;
        if (isset($user->roles[0]->name) && isset($user->branches[0]->id)) {
            $branches = $branches->where('id', $user->branches[0]->id);
            $isSuperAdmin = false;
        }
        $branches = $branches->get();

        $states = State::where('status', 1)
            ->where('country_id', 186)
            ->get();
        return view('content.orders.edit', compact('order', 'customers', 'orderCustomer', 'states', 'branches', 'dateLockWeeks', 'dateLockDays', 'isSuperAdmin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrderRequest $request, Order $order)
    {
        try {

            DB::beginTransaction();

            $customer = $this->customerRepository->firstOrCreate(['email' => $request->input('customer.email')], $request->input('customer'));
            $request = $request->input();
            $order->update([
                'customer_id' => $customer->id,
                'shipment_date' => Carbon::parse($request['shipment_date'])->toDateString(),
                'items' => $request['items'],
                'origin' => $request['branch_id'],
                'destination' => $request['state_id'],
                'name' => $request['sender']['name'],
                'email' => $request['sender']['email'],
                'phone' => $request['sender']['phone'],
                'address' => $request['sender']['address'],
                'updated_by' => auth()->id(),
                'servicetype' => $request['servicetype'],
            ]);
        
            $notificationData = [
                "branch_id" => $order->origin,
                "title" => "Order Updated",
                "description" => "$order->order_number has been updated by " . auth()->user()->first_name,
                "menu" => "Orders",
            ];

            Notification::createNotification($notificationData);

            $destination = $order->destinationState;

            $details['name'] = $customer->first_name . ' ' . $customer->last_name;
            $details['subject'] = "Shipment Details Updated";
            $details['email'] = $customer->email;
            $details['message'] = "Your shipment has been updated on $order->created_at <br><br>
                Tracking ID: $order->order_number (you can track from our website <a href='" . url("/") . "'>click here</a>) <br>
                Order Items: $order->items <br>
                Shipment Date: $order->shipment_date <br>
                Destination: $destination->name <br>
                Service Types: $order->servicetype";

            Mail::send(new GeneralMail($details));

            DB::commit();
            return redirect()->route('order.list')->with(["status" => true, "message" => "Record updated successfully..!"]);
        } catch (\Exception $e) {
            DB::rollBack();
            info($e->getMessage());
            return redirect()->back()->with(["status" => false, "message" => "Record not updated. Please try again later..!"]);
        }
    }

    public function export()
    {
        return Excel::download(new OrderExport(), 'orders.xlsx');
    }

    public function updateShipmentStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'order_status' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $order = Order::findOrFail($request->input('order_id'));
            $order->update([
                'status' => $request->input('order_status'),
            ]);

            Shipment::create([
                'order_id' => $order->id,
                'status' => $request->input('order_status'),
            ]);

            $customer = $order->customer;

            $destination = $order->destinationState;

            $notificationData = [
                "branch_id" => $order->origin,
                "title" => "Order Status Updated",
                "description" => "$order->order_number status has been updated by " . auth()->user()->first_name,
                "menu" => "Orders",
            ];

            Notification::createNotification($notificationData);

            if ($request->input('order_status') === ShipmentStatusEnum::OUT_FOR_DELIVERY) {
                Notification::createNotificationForDeliveryAgents($notificationData);
            }

            $details['name'] = $customer->first_name;
            $details['subject'] = 'Status Update';
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

    public function updateShipmentStatusBulk(Request $request)
    {
        $request->validate([
            'shipment_date' => 'required',
            'status' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $shipmentDate = Carbon::parse($request->input('shipment_date'))->toDateString();
            $user = auth()->user();
            $status = $request->input('status');

            $ordersQuery = Order::whereDate('shipment_date', $shipmentDate)
                ->where('status', '!=', $status);

            if (isset($user->roles[0]->id)) {
                $ordersQuery->where('origin', $user->branches[0]->id);
            }

            $orders = $ordersQuery->get();

            if ($orders->isEmpty()) {
                return redirect()->back()->with(["status" => false, "message" => "No orders found on that date $shipmentDate"]);
            }

            $orderIds = $orders->pluck('id')->toArray();

            // **Bulk Update for Orders**
            Order::whereIn('id', $orderIds)->update(['status' => $status]);

            // **Bulk Insert for Shipments**
            $shipments = [];
            $notifications = [];

            foreach ($orders as $order) {
                $shipments[] = [
                    'order_id' => $order->id,
                    'status' => $status
                ];

                // **Prepare Notification Data**
                $notificationData = [
                    "branch_id" => $order->origin,
                    "title" => "Shipments Updated",
                    "description" => "{$order->order_number} has been updated by " . auth()->user()->first_name,
                    "menu" => "Shipments",
                ];

                // **Condition for OUT_FOR_DELIVERY Notifications**
                if ($status === ShipmentStatusEnum::OUT_FOR_DELIVERY) {
                    $notifications[] = $notificationData;
                }

                // **Queue Email**
                $customer = $order->customer;

                $details['name'] = $customer->first_name;
                $details['subject'] = 'Status Update';
                $details['email'] = $customer->email;
                $details['message'] = "Status Update<br><br>
                Shipment Date: $order->shipment_date<br>
                Order Status: $order->status<br>
                Order Number: $order->order_number<br>
                Order Items: $order->items";

                Mail::send(new GeneralMail($details));
            }

            Shipment::insertOrIgnore($shipments); // **Bulk insert all shipments**

            // **Bulk Send Notifications for Delivery Agents**
            if (!empty($notifications)) {
                foreach ($notifications as $notify) {
                    Notification::createNotificationForDeliveryAgents($notify);
                }
            }

            DB::commit();
            return redirect()->back()->with(["status" => true, "message" => "Records updated successfully..!"]);
        } catch (\Exception $e) {
            DB::rollBack();
            info($e->getMessage());

            dd($e->getMessage()); 
            return redirect()->back()->with(["status" => false, "message" => "Records not updated. Please try again later..!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            DB::beginTransaction();

            $notificationData = [
                "branch_id" => $order->origin,
                "title" => "Order Deleted",
                "description" => "$order->order_number has been deleted by " . auth()->user()->first_name,
                "menu" => "Orders",
            ];
            Notification::createNotification($notificationData);

            Shipment::where('order_id', $order->id)->delete();
            $order->delete();
            DB::commit();
            return response()->json(["status" => true, "message" => "Record deleted successfully..!"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            info($e->getMessage());
            return response()->json(["status" => false, "message" => "Record not deleted. Please try again later..!"], 405);
        }
    }
}