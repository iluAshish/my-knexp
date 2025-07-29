<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
//    public function index()
//    {
//        //
//    }

    public function sortOrder(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $table = $request->table;
            $appPrefix = 'App';
            $model = $appPrefix . '\\Models\\' . $table;
            //            if ($request->extra != NULL) {
            //                $sortOrder = $model::where([['sort_order', '=', $request->sort_order], [$request->extra, '=', $request->extra_key], ['id', '!=', $request->id]])->count();
            //            } else {
            //                $sortOrder = $model::where([['sort_order', '=', $request->sort_order], ['id', '!=', $request->id]])->count();
            //            }
            //            if ($sortOrder) {
            //                return response()->json(['status' => false, 'message' => 'Sort order "' . $request->sort_order . '" has been already taken']);
            //            } else {
            $data = $model::find($request->id);

            $data->sort_order = $request->sort_order;
            if ($data->save()) {
                return response()->json(['status' => true, 'message' => 'Sort order updated successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'Error while updating the sort order']);
            }
            //            }
        } else {
            return response()->json(['status' => false, 'message' => 'Empty value submitted']);
        }
    }

    public function statusChange(Request $request)
    {
        $table = $request->table;
        $state = $request->state;
        $primary_key = $request->primary_key;
        $field = $request->field ?? 'status';
        $limit = $request->limit;
        $limit_field = $request->limit_field;
        $limit_field_value = $request->limit_field_value;

        $status = ($state == 'true') ? "1" : "0";

        $modelClass = 'App\\Models\\' . $table;
        $data = $modelClass::find($primary_key);

        if ($limit && $status == "1") {
            $active_data = $limit_field && $limit_field_value
                ? $modelClass::where($limit_field, $limit_field_value)->where($field, '1')
                : $modelClass::where($field, '1');

            if ($active_data->count() >= $limit) {
                return response()->json([
                    'status' => false,
                    'message' => "Only $limit active items are allowed."
                ]);
            }
        }

        $data->$field = $status;

        if ($data->save()) {

            $notificationData = [
                "branch_id" => 0,
                "title" => "Status Changed",
                "description" => "Status of $table ID $primary_key has been changed by " . auth()->user()->first_name,
                "menu" => $table,
            ];

            Notification::createNotification($notificationData);

            return response()->json([
                'status' => true,
                'message' => 'Status has been changed successfully.'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Error while changing the status.'
        ]);
    }


    public function destroy()
    {
        //
    }
}
