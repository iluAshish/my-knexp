<?php

namespace App\Http\Controllers;

use App\Models\HomeAboutUs;
use App\Http\Requests\StoreHomeAboutUsRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $about_us_form = HomeAboutUs::where('deleted_at', NULL)->get()->first();
        return view(
            'content.home.about_us_form',
            compact('about_us_form')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
        //
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreHomeAboutUsRequest $request)
    // {
        //
    // }

    /**
     * Display the specified resource.
     */
    public function show(HomeAboutUs $homeAboutUs)
    {
        if ($homeAboutUs) {
            return view(
                'content.home.about_us_form',
                compact('homeAboutUs')
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeAboutUs $homeAboutUs)
    {
        $about_us_form = HomeAboutUs::where('deleted_at', NULL)->get()->first();
        if ($homeAboutUs) {
            return view(
                'content.home.about_us_form',
                compact('about_us_form')
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreHomeAboutUsRequest $request, HomeAboutUs $about_u)
    {
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {

                if ($about_u->image) {
                    Storage::delete('public/images/about-us/' . $about_u->image);
                    Storage::delete('public/images/about-us/' . $about_u->image_webp);
                }

                $file = $request->file('image');
                $originalFileName = time() . '.' . $file->getClientOriginalExtension();

                $file->storeAs('public/images/about-us', $originalFileName);
                $about_u->image = $originalFileName;

                $webpFileName = time() . '.webp';
                $webpPath = public_path('storage/images/about-us/' . $webpFileName);

                $image = Image::make($file->getRealPath())->encode('webp', 100);
                $image->save($webpPath);

                $about_u->image_webp = $webpFileName;
            }

            $about_u->title = $request->title;
            $about_u->sub_title = $request->sub_title;
            $about_u->image_attribute = $request->image_attribute;
            $about_u->description = $request->description;
            $about_u->title_2 = $request->title_2;
            $about_u->description_2 = $request->description_2;

            $about_u->save();

            DB::commit();
            return redirect()->back()->with(["status" => true, "message" => "Record successfully updated..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(["status" => false, "message" => "Record not updated. Please try again later..!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeAboutUs $homeAboutUs)
    {
        //
    }
}
