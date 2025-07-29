<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Enquiry;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        return view('content.enquiry.index');
    }

    public function index(Request $request)
    {
        $columns = [
            'enquiries.id',
            'enquiries.reply',
            'enquiries.message',
            'enquiries.name',
            'enquiries.email',
            'enquiries.service_id',
            'enquiries.created_at',
        ];

        $totalData = Enquiry::count();

        $query = Enquiry::select($columns);


        $start = $request->input('start')??1;

        // Apply search filters
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($query) use ($search, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', "%$search%");
                }
            });
        }

        // Total filtered records
        $totalFiltered = $query->count();

        // Order and pagination
        $order = $columns[$request->input('order.0.column')??0];
        $dir = $request->input('order.0.dir')??'DESC';

        $query->offset($start)
            ->limit($request->input('length')??10)
            ->orderBy($order, $dir);


        $data = [];

        if (!empty($query)) {
            // providing a dummy id instead of database ids
            $ids = $start;

            foreach ($query->get() as $record) {
                $services = Service::where('id',$record->service_id)->get()->first();
                $nestedData['id'] = $record->id;
                $nestedData['fake_id'] = +$ids;
                $nestedData['order_number'] = ++$ids;
                $nestedData['reply'] = $record->reply;
                $nestedData['message'] = $record->message;
                $nestedData['name'] = $record->name;
                $nestedData['email'] = $record->email;
                $nestedData['service_id'] = $services->title??'';
                $nestedData['created_at'] = Carbon::parse($record->created_at)->format('d-m-Y');

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
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(StoreEnquiryRequest $request)
//    {
//        //
//    }

    /**
     * Display the specified resource.
     */
//    public function enquiry_view(Enquiry $enquiry)
//    {
//        // dd($enquiry);
//        return view(
//            'content.enquiry.view',
//            compact('enquiry')
//        );
//    }

    /**
     * Display the specified resource.
     */
    public function show(Enquiry $enquiry)
    {
        return view(
            'content.enquiry.view',
            compact('enquiry')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
//    public function edit(Enquiry $enquiry)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     */
//    public function update(UpdateEnquiryRequest $request, Enquiry $enquiry)
//    {
//        //
//    }
    public function enquiryReply(Request $request, Enquiry $enquiry)
    {
        if (isset($request->replay) && $request->replay != null) {
            //    dd($request->all());
            $contact = Enquiry::find($request->id);
            if ($contact) {
                DB::beginTransaction();
                $contact->reply = $request->replay;
                $contact->reply_date = date('Y-m-d h:i:s');
                if ($contact->save()) {
                    if (Helpers::sendServiceEnquiryReply($contact)) {
                        DB::commit();
                        return response()->json(["status" => true, "message" => "Reply saved  Update successfully..!"]);
                    } else {
                        DB::commit();
                        return response()->json(["status" => true, "message" => "Some error occured,please try after sometime 1"]);
                    }
                } else {
                    DB::commit();
                    return response()->json(["status" => true, "message" => "Some error occured,please try after sometime 2"]);
                }
            } else {
                DB::commit();
                return response()->json(["status" => true, "message" => "Already sent reply"]);
            }
        } else {
            DB::commit();
            return response()->json(["status" => true, "message" => "Empty value submitted"]);
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['enquiry_ids' => 'required']);

        try {
            DB::beginTransaction();

            $ids = [];
            foreach ($request->input('enquiry_ids') as $value) {
                if ($value) {
                    $ids[] = $value;
                }
            }

            $recordsDeleted = DB::table('enquiries')->whereIn('id', $ids)->delete();

            DB::commit();
            return response()->json(["status" => true, "message" => "$recordsDeleted Records deleted successfully..!"], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            info($e->getMessage());
            return response()->json(["status" => false, "message" => "Records not deleted. Please try again later..!"], 405);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enquiry $enquiry)
    {
        try {
            DB::beginTransaction();
            $enquiry->delete();
            DB::commit();
            return response()->json(["status" => true, "message" => "Enquiry successfully deleted..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return response()->json(["status" => false, "message" => "Enquiry not deleted. Please try again later..!"]);
        }
    }
}
