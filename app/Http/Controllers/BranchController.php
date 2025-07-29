<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBranchRequest;
use App\Models\State;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {

        return view('content.branches.index');
    }

    public function index(Request $request)
    {

        $columns = [
            1 => 'id',
            2 => 'state_id',
            3 => 'name',
            4 => 'branch_code',
            5 => 'phone',
            6 => 'status',
            7 => 'created_at',
        ];

        $totalData = Branch::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $branches = Branch::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $branches = Branch::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Branch::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($branches)) {
            // providing a dummy id instead of database ids
            $ids = $start;

            foreach ($branches as $branch) {
                $nestedData['id'] = $branch->id;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['state'] = $branch->state->name;
                $nestedData['name'] = $branch->name;
                $nestedData['branch_code'] = $branch->branch_code;
                $nestedData['phone'] = $branch->phone;
                $nestedData['status'] = $branch->status;

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
        $states = State::where('deleted_at',NULL)->where('status',1)->where('country_id',141)->get();
        return view('content.branches.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBranchRequest $request)
    {
        try {
            DB::beginTransaction();

            Branch::create([
                "name" => $request->name,
                "state_id" => $request->state_id,
                "branch_code" => $request->branch_code,
                "phone" => $request->phone,
                "address" => $request->address,
                "status" => 1,
                "created_by" => auth()->user()->id,
                "updated_by" => auth()->user()->id,
            ]);

            DB::commit();
            return redirect()->route('branch.list')->with(["status" => true, "message" => "Record added successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(["status" => false, "message" => "Record not added. Please try again later..!"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        return view('content.branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        $states = State::where('deleted_at',NULL)->where('status',1)->where('country_id',141)->get();
        return view('content.branches.edit', compact('branch','states'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBranchRequest $request, Branch $branch)
    {
        try {
            DB::beginTransaction();

            $branch->update([
                "name" => $request->name,
                "state_id" => $request->state_id,
                "branch_code" => $request->branch_code,
                "phone" => $request->phone,
                "address" => $request->address,
                "updated_by" => auth()->user()->id,
            ]);

            DB::commit();
            return redirect()->route('branch.list')->with(["status" => true, "message" => "Record updated successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(["status" => false, "message" => "Record not updated. Please try again later..!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        try {
            DB::beginTransaction();

            $exists = DB::table('branch_users')->where('branch_id', $branch->id)->exists();

            if ($exists) {
                return response()->json(["status" => false, "message" => "Can't delete! Orders and Users are related to the branch."]);
            }

            $branch->delete();

            DB::commit();
            return response()->json(["status" => true, "message" => "Record deleted successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return response()->json(["status" => false, "message" => "Record not deleted. Please try again later..!"]);
        }
    }
}
