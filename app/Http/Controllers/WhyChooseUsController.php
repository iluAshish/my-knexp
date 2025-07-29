<?php

namespace App\Http\Controllers;

use App\Models\WhyChooseUs;
use App\Http\Requests\StoreWhyChooseUsRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class WhyChooseUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $why_choose_us = WhyChooseUs::where('deleted_at',NULL)->get()->first();
        return view(
            'content.home.why_choose_us_form',
            compact('why_choose_us')
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
//    public function store(StoreWhyChooseUsRequest $request)
//    {
//        //
//    }

    /**
     * Display the specified resource.
     */
//    public function show(WhyChooseUs $whyChooseUs)
//    {
//        //
//    }

    /**
     * Show the form for editing the specified resource.
     */
//    public function edit(WhyChooseUs $whyChooseUs)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreWhyChooseUsRequest $request, WhyChooseUs $whychooseu)
    {

        try {
            DB::beginTransaction();
            // $whychooseu = new WhyChooseUs;
            if ($request->hasFile('image')) {
                if ($request->image) {
                    Storage::delete('public/images/whychooseus/' . $whychooseu->image);
                    Storage::delete('public/images/whychooseus/' . $whychooseu->image_webp);
                }
                $file = $request->file('image');
                $originalFileName = time() . '.' . $file->getClientOriginalExtension();

                $file->storeAs('public/images/whychooseus/image', $originalFileName);
                $whychooseu->image = $originalFileName;

                $webpFileName = time() . '.webp';
                $webpPath = public_path('storage/images/whychooseus/image' . $webpFileName);

                $image = Image::make($file->getRealPath())->encode('webp', 100);
                $image->save($webpPath);
                $whychooseu->image_webp = $webpFileName;
            }

            if ($request->hasFile('icon_1')) {
                if ($request->icon_1) {
                    Storage::delete('public/images/whychooseus/icon/' . $whychooseu->icon_1);
                }
                $file_icon_1 = $request->file('icon_1');

                $originalFileName1 = 'icon_1'.time() . '.' . $file_icon_1->getClientOriginalExtension();
                $file_icon_1->storeAs('public/images/whychooseus/icon/', $originalFileName1);
                $whychooseu->icon_1 = $originalFileName1;

            }
            if ($request->hasFile('icon_2')) {
                if ($request->icon_2) {
                    Storage::delete('public/images/whychooseus/icon/' . $whychooseu->icon_2);
                }

                $file_icon_2 = $request->file('icon_2');
                $originalFileName2 = 'icon_2'.time() . '.' . $file_icon_2->getClientOriginalExtension();
                $file_icon_2->storeAs('public/images/whychooseus/icon/', $originalFileName2);
                $whychooseu->icon_2 = $originalFileName2;
            }
            if ($request->hasFile('icon_3')) {
                if ($request->icon_3) {
                    Storage::delete('public/images/whychooseus/icon/' . $whychooseu->icon_3);
                }
                $file_icon_3 = $request->file('icon_3');
                $originalFileName3 = 'icon_3'.time() . '.' . $file_icon_3->getClientOriginalExtension();
                $file_icon_3->storeAs('public/images/whychooseus/icon/', $originalFileName3);
                $whychooseu->icon_3 = $originalFileName3;
            }
            $whychooseu->title = $request->title ?? '';
            $whychooseu->sub_title = $request->sub_title ?? '';
            $whychooseu->image_attribute = $request->image_attribute ?? '';

            // $whychooseu->icon_1 = $request->icon_1 ?? '';
            $whychooseu->icon_title_1 = $request->icon_title_1 ?? '';
            $whychooseu->icon_desc_1 = $request->icon_desc_1 ?? '';

            // $whychooseu->icon_2 = $request->icon_2 ?? '';
            $whychooseu->icon_title_2 = $request->icon_title_2 ?? '';
            $whychooseu->icon_desc_2 = $request->icon_desc_2 ?? '';

            // $whychooseu->icon_3 = $request->icon_3 ?? '';
            $whychooseu->icon_title_3 = $request->icon_title_3 ?? '';
            $whychooseu->icon_desc_3 = $request->icon_desc_3 ?? '';


            // dd($whychooseu);
            $whychooseu->save();

            DB::commit();
            return redirect()->back()->with(["status" => true, "message" => "Why Choose Us content updated successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(["status" => false, "message" => "Why Choose Us Content not updated. Please try again later..!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WhyChooseUs $whyChooseUs)
    {
        //
    }
}
