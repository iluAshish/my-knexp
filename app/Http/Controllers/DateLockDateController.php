<?php

namespace App\Http\Controllers;

use App\Models\DateLockDate;
use App\Http\Requests\StoreDateLockDateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DateLockDateController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function list()
    {

        return view('content.date.index');
    }

    public function index(Request $request)
    {

        $columns = [
            1 => 'id',
            2 => 'week_dates',
            3 => 'created_at',
        ];

        $totalData = DateLockDate::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $dates = DateLockDate::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $dates = DateLockDate::where('id', 'LIKE', "%{$search}%")
                ->orWhere('week_dates', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = DateLockDate::where('id', 'LIKE', "%{$search}%")
                ->orWhere('week_dates', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($dates)) {
            // providing a dummy id instead of database ids
            $ids = $start;

            foreach ($dates as $date) {
                $nestedData['id'] = $date->id;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['week_dates'] = $date->week_dates;

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
        return view('content.date.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDateLockDateRequest $request)
    {
        try {
            DB::beginTransaction();
            DateLockDate::create([
                "name" => $request->name,
                "week_dates" => $request->week_dates,
                "created_by" => auth()->user()->id ?? 1,
            ]);

            DB::commit();
            return redirect()->route('date.list')->with(["status" => true, "message" => "Record added successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(["status" => false, "message" => "Record not added. Please try again later..!"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DateLockDate $date)
    {
        return view('content.date.show', compact('date'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DateLockDate $date)
    {
        return view('content.date.edit', compact('date'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDateLockDateRequest $request, DateLockDate $date)
    {
        try {
            DB::beginTransaction();

            $date->update([
                "name" => $request->name,
                "week_dates" => $request->week_dates,
                "updated_by" => auth()->user()->id ?? 1,
            ]);

            DB::commit();
            return redirect()->route('date.list')->with(["status" => true, "message" => "Record updated successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(["status" => false, "message" => "Record not updated. Please try again later..!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DateLockDate $date)
    {
        try {
            DB::beginTransaction();

            $date->delete();

            DB::commit();
            return response()->json(["status" => true, "message" => "Record deleted successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return response()->json(["status" => false, "message" => "Record not deleted. Please try again later..!"]);
        }
    }
}
