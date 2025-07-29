<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;

use App\Models\keyFeature;
use App\Http\Requests\StorekeyFeatureRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class KeyFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keyfeatures = keyFeature::where('deleted_at', NULL)->get();
        return view('content.home.keyfeature.list', compact('keyfeatures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $key = "Create";
        $title = "Create Key Feature";
        return view('content.home.keyfeature.form_create', compact('key', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorekeyFeatureRequest $request)
    {
        // dd($request);
        try {
            DB::beginTransaction();
            $keyfeature = new keyFeature;

            if ($request->hasFile('image')) {

                if ($keyfeature->image) {
                    Storage::delete('public/images/keyfeature/' . $keyfeature->image);
                    Storage::delete('public/images/keyfeature/' . $keyfeature->image_webp);
                }

                $file = $request->file('image');
                $originalFileName = time() . '.' . $file->getClientOriginalExtension();

                $file->storeAs('public/images/keyfeature', $originalFileName);
                $keyfeature->image = $originalFileName;

                $webpFileName = time() . '.webp';
                $webpPath = public_path('storage/images/keyfeature/' . $webpFileName);

                $image = Image::make($file->getRealPath())->encode('webp', 100);
                $image->save($webpPath);

                $keyfeature->image_webp = $webpFileName;
            }
            $active_count = keyFeature::where('status', '1')->where('deleted_at', NULL)->count();
            if ($active_count > 1) {
                $keyfeature->status = '0';
            } else {
                $keyfeature->status = '1';
            }
            $sort_order = keyFeature::orderBy('sort_order', 'DESC')->first();

            if ($sort_order) {
                $sort_number = ($sort_order->sort_order + 1);
            } else {
                $sort_number = 1;
            }
            $keyfeature->title = $request->title ?? '';
            $keyfeature->image_attribute = $request->image_attribute ?? '';
            $keyfeature->counter = $request->number ?? '';
            $keyfeature->sort_order = $sort_number;
            // dd($keyfeature);
            $keyfeature->save();

            DB::commit();
            return redirect('admin/home/keyfeature')->with(["status" => true, "message" => "Key Feature added successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect('admin/home/keyfeature')->with(["status" => false, "message" => "Key Feature not added. Please try again later..!"]);
        }
    }

    /**
     * Display the specified resource.
     */
//    public function show(keyFeature $keyFeature)
//    {
//        //
//    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(keyFeature $keyfeature)
    {
        // dd($id);
        $key = "Update";
        $title = "Edit Key Feature";
        $keyfeature = $keyfeature;
        // $keyfeature = $keyfeature->original;
        if ($keyfeature) {
            return view(
                'content.home.keyfeature.form',
                compact('key', 'keyfeature', 'title')
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorekeyFeatureRequest $request, keyFeature $keyfeature)
    {
        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {

                if ($keyfeature->image) {
                    Storage::delete('public/images/keyfeature/' . $keyfeature->image);
                    Storage::delete('public/images/keyfeature/' . $keyfeature->image_webp);
                }

                $file = $request->file('image');
                $originalFileName = time() . '.' . $file->getClientOriginalExtension();

                $file->storeAs('public/images/keyfeature', $originalFileName);
                $keyfeature->image = $originalFileName;

                $webpFileName = time() . '.webp';
                $webpPath = public_path('storage/images/keyfeature/' . $webpFileName);

                $image = Image::make($file->getRealPath())->encode('webp', 100);
                $image->save($webpPath);

                $keyfeature->image_webp = $webpFileName;
            }
            // $active_count = keyFeature::where('status', '1')->where('deleted_at', NULL)->count();
            // if ($active_count > 2) {
            //     $keyfeature->status = '0';
            // } else {
            //     $keyfeature->status = '1';
            // }
            $keyfeature->title = $request->title ?? '';
            $keyfeature->image_attribute = $request->image_attribute ?? '';
            $keyfeature->counter = $request->number ?? '';

            $keyfeature->save();

            DB::commit();
            return redirect('admin/home/keyfeature')->with(["status" => true, "message" => "Key Feature update successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect('admin/home/keyfeature')->with(["status" => false, "message" => "Key Feature not update. Please try again later..!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(keyFeature $keyfeature)
    {
        try {
            DB::beginTransaction();

            if ($keyfeature->image) {
                Storage::delete('public/images/keyfeature/' . $keyfeature->image);
                Storage::delete('public/images/keyfeature/' . $keyfeature->image_webp);
            }
            $keyfeature->delete();
            DB::commit();
            return response()->json(["status" => true, "message" => "Key Feature deleted successfully..!"]);

        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return response()->json(["status" => false, "message" => "Key Feature not deleted. Please try again later..!"]);
        }
    }
}
