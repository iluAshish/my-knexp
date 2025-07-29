<?php

namespace App\Http\Controllers;

use App\Models\DateLockWeek;
use App\Http\Requests\StoreDateLockWeekRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DateLockWeekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {

        return view('content.day.index');
    }
    public function index(Request $request)
    {
        $columns = [
            1 => 'id',
            2 => 'week_days',
            3 => 'created_at',
        ];

        $totalData = DateLockWeek::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $days = DateLockWeek::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $days = DateLockWeek::Where('week_days', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            $totalFiltered = DateLockWeek::where('id', 'LIKE', "%{$search}%")
                ->orWhere('week_days', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($days)) {
            // providing a dummy id instead of database ids
            $ids = $start;
            $daysArray = [0 => 'Sunday',1 => 'Monday',2 => 'Tuesday',3 => 'Wednesday',4 => 'Thursday',5 => 'Friday',6 => 'Saturday'];
            $selected = '';
            foreach ($days as $day) {
                foreach ($daysArray as $key => $value) {
                    if ($day->week_days == $key) {
                        $selected = $value;
                    }
                }
                $nestedData['fake_id'] = ++$ids;
                $nestedData['id'] = $day->id;
                $nestedData['week_days'] = $selected;

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
        $daysArray = [0 => 'Sunday',1 => 'Monday',2 => 'Tuesday',3 => 'Wednesday',4 => 'Thursday',5 => 'Friday',6 => 'Saturday'];
        return view('content.day.create',compact('daysArray'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDateLockWeekRequest $request)
    {
        try {
            DB::beginTransaction();
            DateLockWeek::create([
                "name" => $request->name,
                "week_days" => $request->week_days,
                "created_by" => auth()->user()->id ?? 1,
            ]);

            DB::commit();
            return redirect()->route('day.list')->with(["status" => true, "message" => "Record added successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(["status" => false, "message" => "Record not added. Please try again later..!"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DateLockWeek $day)
    {
        $daysArray = [0 => 'Sunday',1 => 'Monday',2 => 'Tuesday',3 => 'Wednesday',4 => 'Thursday',5 => 'Friday',6 => 'Saturday'];
        return view('content.day.show', compact('day','daysArray'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DateLockWeek $day)
    {
        $daysArray = [0 => 'Sunday',1 => 'Monday',2 => 'Tuesday',3 => 'Wednesday',4 => 'Thursday',5 => 'Friday',6 => 'Saturday'];
        return view('content.day.edit', compact('day','daysArray'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDateLockWeekRequest $request, DateLockWeek $day)
    {
        try {
            DB::beginTransaction();

            $day->update([
                "name" => $request->name,
                "week_days" => $request->week_days,
                "updated_by" => auth()->user()->id ?? 1,
            ]);

            DB::commit();
            return redirect()->route('day.list')->with(["status" => true, "message" => "Record updated successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(["status" => false, "message" => "Record not updated. Please try again later..!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DateLockWeek $day)
    {
        try {
            DB::beginTransaction();

            $day->delete();

            DB::commit();
            return response()->json(["status" => true, "message" => "Record deleted successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return response()->json(["status" => false, "message" => "Record not deleted. Please try again later..!"]);
        }
    }
}
