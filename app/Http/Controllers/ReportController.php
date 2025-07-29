<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\Branch;
use App\Models\Order;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function list()
    {
        $branches = Branch::where('status', 1)->get();
        $states = State::where('status', 1)
            ->where('country_id', 186)
            ->get();

        return view('content.reports.index', compact('branches', 'states'));
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
        ];


        $query = Order::select($columns)
            ->join('users', 'orders.updated_by', '=', 'users.id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->join('branches', 'orders.origin', '=', 'branches.id')
            ->join('states', 'orders.destination', '=', 'states.id');

        $user = auth()->user();
        if (isset($user->branches[0])) {
            $query->where('orders.origin', $user->branches[0]->id);
        }

        $totalData = $query->count();
        $start = $request->input('start');

        // Date filter
        $start_date = $request->start_date ? Carbon::parse($request->start_date)->toDateString() : null;
        $end_date = $request->end_date ? Carbon::parse($request->end_date)->toDateString() : null;
        if ($start_date) {
            $query->whereDate('orders.shipment_date', '>=', $start_date);
        }
        if ($end_date) {
            $query->whereDate('orders.shipment_date', '<=', $end_date);
        }

        // Status filter
        if ($request->input('status')) {
            $query->where('orders.status', $request->input('status'));
        }
        // Origin (branch)
        if ($request->input('branch_id')) {
            $query->where('orders.origin', $request->input('branch_id'));
        }
        // Destination (state)
        if ($request->input('state_id')) {
            $query->where('orders.destination', $request->input('state_id'));
        }

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

    public function export(Request $request)
    {
        $filters['startDate'] = $request->input('start_date');
        $filters['endDate'] = $request->input('end_date');
        $filters['status'] = $request->input('status');
        $filters['branchId'] = $request->input('branch_id');
        $filters['stateId'] = $request->input('state_id');

        return Excel::download(new ReportExport($filters), 'reports.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
