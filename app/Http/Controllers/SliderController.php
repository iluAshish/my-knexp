<?php

namespace App\Http\Controllers;

use App\Models\HomeSlider;
use App\Http\Requests\StoreHomeSliderRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliderList = HomeSlider::where('deleted_at', NULL)->get();
        return view('content.home.slider.slider_list', compact('sliderList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $key = "Create";
        $title = "Create Slider";
        // $slider = $slider->original;

        return view('content.home.slider.slider_form_create', compact('key', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHomeSliderRequest $request)
    {

        try {
            DB::beginTransaction();
            $slider = new HomeSlider;
            if ($request->hasFile('image')) {

                if ($slider->image) {
                    Storage::delete('public/images/slider/' . $slider->image);
                    Storage::delete('public/images/slider/' . $slider->image_webp);
                }

                $file = $request->file('image');
                $originalFileName = time() . '.' . $file->getClientOriginalExtension();

                $file->storeAs('public/images/slider', $originalFileName);
                $slider->image = $originalFileName;

                $webpFileName = time() . '.webp';
                $webpPath = public_path('storage/images/slider/' . $webpFileName);

                $image = Image::make($file->getRealPath())->encode('webp', 100);
                $image->save($webpPath);

                $slider->image_webp = $webpFileName;
            }
            $active_count = HomeSlider::where('status', '1')->where('deleted_at', NULL)->count();
            if ($active_count > 3) {
                $slider->status = '0';
            } else {
                $slider->status = '1';
            }

            $sort_order = HomeSlider::orderBy('sort_order', 'DESC')->first();

            if ($sort_order) {
                $sort_number = ($sort_order->sort_order + 1);
            } else {
                $sort_number = 1;
            }
            $slider->title = $request->title ?? '';

            $slider->sub_title = $request->sub_title ?? '';
            $slider->image_attribute = $request->image_attribute ?? '';
            $slider->button_url = ($request->button_url) ?? 'KN Express';
            $slider->button_txt = ($request->button_txt) ?? '#';
            $slider->sort_order = $sort_number;
            $slider->save();

            DB::commit();
            return redirect('admin/home/slider')->with(["status" => true, "message" => "Slider added successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(["status" => false, "message" => "Slider not added. Please try again later..!"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeSlider $homeSlider, $id)
    {
        $slider = HomeSlider::find($id);
        // dd($slider);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeSlider $homeSlider, $id)
    {
        // dd($id);
        $key = "Update";
        $title = "Edit Slider";
        $slider = HomeSlider::find($id);
        // $slider = $slider->original;
        if ($slider) {
            return view(
                'content.home.slider.slider_form',
                compact('key', 'slider', 'title')
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreHomeSliderRequest $request, HomeSlider $slider)
    {
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {

                if ($slider->image) {
                    Storage::delete('public/images/slider/' . $slider->image);
                    Storage::delete('public/images/slider/' . $slider->image_webp);
                }

                $file = $request->file('image');
                $originalFileName = time() . '.' . $file->getClientOriginalExtension();

                $file->storeAs('public/images/slider', $originalFileName);
                $slider->image = $originalFileName;

                $webpFileName = time() . '.webp';
                $webpPath = public_path('storage/images/slider/' . $webpFileName);

                $image = Image::make($file->getRealPath())->encode('webp', 100);
                $image->save($webpPath);

                $slider->image_webp = $webpFileName;
            }

            $slider->title = $request->title;
            $slider->sub_title = $request->sub_title;
            $slider->image_attribute = $request->image_attribute;
            $slider->button_url = ($request->button_url) ?? 'KN Express';
            $slider->button_txt = ($request->button_txt) ?? '#';

            $slider->save();

            DB::commit();
            return  redirect('admin/home/slider')->with(["status" => true, "message" => "Record updated successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(["status" => false, "message" => "Record not updated. Please try again later..!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeSlider $slider)
    {
        try {
            DB::beginTransaction();

            if ($slider->image) {
                Storage::delete('public/images/slider/' . $slider->image);
                Storage::delete('public/images/slider/' . $slider->image_webp);
            }

            $slider->delete();
            DB::commit();
            return response()->json(["status" => true, "message" => "Record deleted successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return response()->json(["status" => false, "message" => "Record not deleted. Please try again later..!"]);
        }
    }
}
