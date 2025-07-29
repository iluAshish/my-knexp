<?php

namespace App\Http\Controllers;

use App\Models\SiteInformation;
use App\Http\Requests\StoreSiteInformationRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SiteInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siteInformation = SiteInformation::where('deleted_at',NULL)->get()->first();
        return view(
            'content.site-information.form',
            compact('siteInformation')
        );
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
//    public function store(StoreSiteInformationRequest $request)
//    {
//        //
//    }

    /**
     * Display the specified resource.
     */
//    public function show(SiteInformation $siteInformation)
//    {
//        //
//    }

    /**
     * Show the form for editing the specified resource.
     */
//    public function edit(SiteInformation $siteInformation)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSiteInformationRequest $request, SiteInformation $siteinformation)
    {
        try {
            DB::beginTransaction();
            $siteinformation->updated_at = date('Y-m-d h:i:s');


            if ($request->hasFile('logo')) {

                if ($siteinformation->logo) {
                    Storage::delete('public/site_information/logo/' . $siteinformation->logo);
                    Storage::delete('public/site_information/logo/' . $siteinformation->logo_webp);
                }

                $file = $request->file('logo');
                $originalFileName = 'logo'.time() . '.' . $file->getClientOriginalExtension();

                $file->storeAs('public/site_information/logo/', $originalFileName);
                $siteinformation->logo = $originalFileName;

                $webpFileName = 'logo'.time() . '.webp';
                $webpPath = public_path('storage/site_information/logo/' . $webpFileName);

                $image = Image::make($file->getRealPath())->encode('webp', 100);
                $image->save($webpPath);

                $siteinformation->logo_webp = $webpFileName;
            }

            if ($request->hasFile('dashboard_logo')) {

                if ($siteinformation->dashboard_logo) {
                    Storage::delete('public/site_information/dashboard_logo/' . $siteinformation->dashboard_logo);
                }

                $file = $request->file('dashboard_logo');
                $originalFileName = 'dashboard_logo'.time() . '.' . $file->getClientOriginalExtension();

                $file->storeAs('public/site_information/dashboard_logo/', $originalFileName);
                $siteinformation->dashboard_logo = $originalFileName;
            }
           if ($request->hasFile('footer_logo')) {

            if ($siteinformation->footer_logo) {
                Storage::delete('public/site_information/footer_logo/' . $siteinformation->footer_logo);
                Storage::delete('public/site_information/footer_logo/' . $siteinformation->footer_logo_webp);
            }

            $file = $request->file('footer_logo');
            $originalFileName = 'footer_logo'.time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/site_information/footer_logo/', $originalFileName);
            $siteinformation->footer_logo = $originalFileName;

            $webpFileName = 'footer_logo'.time() . '.webp';
            $webpPath = public_path('storage/site_information/footer_logo/' . $webpFileName);

            $image = Image::make($file->getRealPath())->encode('webp', 100);
            $image->save($webpPath);

            $siteinformation->footer_logo_webp = $webpFileName;
        }

            $siteinformation->brand_name = $request->brand_name??'';

            $siteinformation->logo_attribute = $request->logo_attribute??'';
            // $siteinformation->dashboard_logo_attribute = $request->dashboard_logo_attribute ?? '';

            $siteinformation->email = $request->email??'';
            $siteinformation->alternate_email = $request->alternate_email??'';
            $siteinformation->email_recipient = $request->email_recipient??'';
            $siteinformation->phone = $request->phone??'';
            $siteinformation->landline = $request->landline??'';
            $siteinformation->whatsapp_number = $request->whatsapp_number??'';

            // social media links
            $siteinformation->facebook_url = $request->facebook_url??'';
            $siteinformation->instagram_url = $request->instagram_url??'';
            $siteinformation->twitter_url = $request->twitter_url??'';
            $siteinformation->linkedin_url = $request->linkedin_url??'';
            $siteinformation->youtube_url = $request->youtube_url??'';
            $siteinformation->pinterest_url = $request->pinterest_url??'';
            $siteinformation->snapchat_url = $request->snapchat_url??'';
            // $siteinformation->telegram_url = $request->telegram_url??'';
            $siteinformation->tiktok_url = $request->tiktok_url??'';

            $siteinformation->footer_logo_attribute = $request->footer_logo_attribute??'';
            $siteinformation->address = $request->address??'';

            $siteinformation->location = $request->location??'';
            // $siteinformation->copyright = $request->copyright??'';

            // $siteinformation->terms_and_conditions = $request->terms_and_conditions??'';
            // $siteinformation->privacy_policy = $request->privacy_policy??'';

            $siteinformation->working_hours = $request->working_hours??'';

            $siteinformation->footer_text = $request->footer_text??'';
            $siteinformation->header_tag = $request->header_tag??'';
            $siteinformation->footer_tag = $request->footer_tag??'';
            $siteinformation->body_tag = $request->body_tag??'';

            $siteinformation->save();

            DB::commit();
            return redirect()->back()->with(["status" => true, "message" => "Site Setting Update successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(["status" => false, "message" => "Site Setting not update. Please try again later..!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SiteInformation $siteInformation)
    {
        //
    }
}
