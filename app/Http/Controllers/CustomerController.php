<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function list()
    {

        return view('content.customers.index');
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id',
            2 => 'first_name',
            3 => 'email',
            4 => 'phone',
            5 => 'created_at',
        ];

        $totalData = Customer::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $customer = Customer::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $customer = Customer::where('id', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Customer::where('id', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($customer)) {
            // providing a dummy id instead of database ids
            $ids = $start;

            foreach ($customer as $user) {
                $nestedData['id'] = $user->id;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['name'] = $user->first_name . ' ' . $user->last_name;
                $nestedData['email'] = $user->email;
                $nestedData['phone'] = $user->phone;

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
        return view('content.customers.create');
    }

    public function export()
    {
        return Excel::download(new CustomerExport(), 'customers.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        try {
            DB::beginTransaction();

            Customer::create([
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "email" => $request->email,
                "phone" => $request->phone,
                "address" => $request->address,
                "status" => 1,
                "created_by" => auth()->user()->id ?? 1,
            ]);

            DB::commit();
            return redirect()->route('customer.list')->with(["status" => true, "message" => "Record added successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(["status" => false, "message" => "Record not added. Please try again later..!"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('content.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('content.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        try {
            DB::beginTransaction();

            $customer->update([
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "email" => $request->email,
                "phone" => $request->phone,
                "address" => $request->address,
                "updated_by" => auth()->user()->id ?? 1,
            ]);

            DB::commit();
            return redirect()->route('customer.list')->with(["status" => true, "message" => "Record updated successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(["status" => false, "message" => "Record not updated. Please try again later..!"]);
        }
    }

    public function checkCustomerAlreadyExist(Request $request)
    {
        try {
            $status = Customer::where('email', $request->input('email'))->exists();

            return response()->json(["status" => $status, "message" => "Customer already exists!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(["status" => false, "message" => "Something went wrong!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        try {
            DB::beginTransaction();

            $customerExist = Order::where('customer_id', $customer->id)->exists();
            if ($customerExist) {
                return response()->json(["status" => false, "message" => "Record not deleted. Customer has orders"]);
            }

            $customer->delete();

            DB::commit();
            return response()->json(["status" => true, "message" => "Record deleted successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return response()->json(["status" => false, "message" => "Record not deleted. Please try again later..!"]);
        }
    }
}
