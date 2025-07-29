<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Enquiry;
use App\Models\HomeAboutUs;
use App\Models\HomeSlider;
use App\Models\keyFeature;
use App\Models\Order;
use App\Models\Service;
use App\Models\SiteInformation;
use App\Models\WhyChooseUs;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WebController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siteInformation = SiteInformation::where('deleted_at',NULL)->get()->first();
        $sliders = HomeSlider::whereNull('deleted_at')->where('status','1')->orderby('sort_order','ASC')->get();
        $about_us = HomeAboutUs::where('deleted_at', NULL)->get()->first();
        $keyfeatures = keyFeature::where('deleted_at', NULL)->where('status','1')->orderby('sort_order','ASC')->get();
        $why_choose_us = WhyChooseUs::where('deleted_at',NULL)->get()->first();
        $services = Service::where('deleted_at',NULL)->where('status','1')->orderby('sort_order','ASC')->get();
        return view(
            'content.web.index',
            compact('siteInformation','sliders','about_us','keyfeatures','why_choose_us','services')
        );
    }

    public function thankyou()
    {
        $siteInformation = SiteInformation::where('deleted_at',NULL)->get()->first();
        $services = Service::where('deleted_at',NULL)->where('status','1')->orderby('sort_order','ASC')->get();
        $title = 'title';
        return view(
            'content.web.thankyou',
            compact('title','services','siteInformation')
        );
    }

    public function enquiry_form(Request $request)
    {
        $enquiry = new Enquiry();
        $enquiry->name = $request->name;
        $enquiry->phone = $request->phone;
        $enquiry->email = $request->email;
        $enquiry->service_id = $request->service_id;
        $enquiry->message = $request->message ?? '';
        $enquiry->request_url = url()->previous();
        $enquiry->enquiry_type = $request->enquiry_type ? $request->enquiry_type : 'service-detail';
        $enquiry->save();
        $sendContactMail = Helpers::SendServiceEnquiryMail($enquiry);
        if (!$sendContactMail) {

        }
        return redirect()->route('thankyou');
    }

    public function search(Request $request)
    {
        try {

            $order = Order::where('order_number', $request->input('order_number'))->first();

            $formattedShipments = $order->shipments->map(function ($shipment) {
                $createdAtDate = Carbon::parse($shipment->created_at);

                $createdAtDateDubai = $createdAtDate->setTimezone('Asia/Dubai');

                $formattedDate = $createdAtDateDubai->format('d M Y');
                $formattedTime = $createdAtDateDubai->format('H:i A');

                return [
                    'status' => $shipment->status,
                    'formatted_date' => $formattedDate,
                    'formatted_time' => $formattedTime,
                    'created_at' => $shipment->created_at,
                ];
            });

            $data = [
                'order' => $order,
                'shipments' => $formattedShipments,
                'delivery_comments' => $order->deliveryComments,
            ];

            return response()->json(["status" => true, "message" => "Record Found.", "data" => $data], 200);

        } catch (\Exception $e) {
            info($e->getMessage());
            return response()->json(["status" => false, "message" => "Record Not Found."], 405);
        }
    }

    public function destroy()
    {
        //
    }
}
