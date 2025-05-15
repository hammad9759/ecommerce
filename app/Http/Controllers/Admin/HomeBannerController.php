<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeBanner;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\File;
use Validator;

class HomeBannerController extends Controller
{

    use ApiResponse;

    // Display all banners
    public function index(){
        $banners = HomeBanner::all();
        return view('admin.banners.homeBanner', compact('banners'));
    }

    // Store new banner
    public function store(Request $request){
        $validation = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(),404,'Error');
        }else{
            if ($request->hasFile('image')) {
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('uploads/banners'), $imageName);
            } else {
                $imageName = null;
            }
            HomeBanner::create([
                'title' => $request->title,
                'description' => $request->description,
                'url' => $request->url,
                'image' => $imageName,
                'status' => $request->status
            ]);
            return $this->success(200,'Added Banner successfully');
        }

    }

    // Update banner
    public function update(Request $request, $id)
    {
        $banner = HomeBanner::findOrFail($id);
        $validation = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:Active,Inactive',
        ]);
        if ($validation->fails()) {
            return $this->error($validation->errors()->first(),404,'Error');
        }else{
            if ($request->hasFile('image')) {
                // Delete old image
                if ($banner->image) {
                    File::delete(public_path('uploads/banners/' . $banner->image));
                }
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('uploads/banners'), $imageName);
                $banner->image = $imageName;
            }
            $banner->title = $request->title;
            $banner->description = $request->description;
            $banner->url = $request->url;
            $banner->status = $request->status;
            $banner->save();
        }
        return $this->success(200,'Updated Banner successfully');
    }

    // Delete banner
    public function destroy(Request $request, $id)
    {
        $banner = HomeBanner::findOrFail($id);
        if ($banner->image) {
            File::delete(public_path('uploads/banners/' . $banner->image));
        }

        $banner->delete();
        return redirect()->route('admin.homeBanner')->with('success', 'Banner deleted successfully.');
    }

    // Change status
    public function changeStatus($id)
    {
        $banner = HomeBanner::findOrFail($id);
        $banner->status = $banner->status == 'Active' ? 'Inactive' : 'Active';
        $banner->save();
        return response()->json([
            "status" => "Success",
            "message" => "Status updated successfully",
            "newStatus" => $banner->status
        ]);
    }
}
