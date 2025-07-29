<?php

namespace App\Http\Controllers;

use App\Exports\NotificationExport;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class NotificationController extends Controller
{

    public function list()
    {
        return view('content.notifications.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = [
            1 => 'notifications.id',
            'notifications.user_id',
            'notifications.title',
            'notifications.description',
            'notifications.menu',
            'notifications.created_by',
            'notifications.created_at',
            'users.first_name as first_name',
            'users.last_name as last_name',
            'u2.first_name as u_first_name',
            'u2.last_name as u_last_name',
        ];

        $user = Auth::user();

        $startDate = Carbon::now()->subDays(30)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $query = Notification::select($columns)
            ->where('user_id', $user->id)
            ->whereDate('notifications.created_at', '>=', $startDate)
            ->whereDate('notifications.created_at', '<=', $endDate)
            ->join('users', 'notifications.created_by', '=', 'users.id')
            ->join('users as u2', 'notifications.user_id', '=', 'u2.id');

        $totalData = $query->count();

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
        $query->offset($request->input('start'))
            ->limit($request->input('length'))
            ->orderBy($order, $dir);

        $data = [];

        if (!empty($query)) {
            // providing a dummy id instead of database ids
            $ids = $request->input('start');

            foreach ($query->get() as $record) {
                $nestedData['id'] = $record->id;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['user_id'] = $record->user_name;
                $nestedData['title'] = $record->title;
                $nestedData['description'] = $record->description;
                $nestedData['menu'] = $record->menu;
                $nestedData['created_by'] = $record->created_by_name;

                $data[] = $nestedData;
            }
        }

        $response = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data,
        ];

        return response()->json($data ? $response : [
            'message' => 'Internal Server Error',
            'code' => 500,
            'data' => [],
        ]);
    }

    public function export()
    {
        return Excel::download(new NotificationExport(), 'notifications.xlsx');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
