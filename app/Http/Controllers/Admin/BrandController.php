<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\File;
use Validator;

class BrandController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $brands = Brand::all();
        return view('admin.brands.brands', compact('brands')); // Ensure your view path is correct
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 404, 'Error');
        } else {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/brands'), $imageName);

            Brand::create([
                'name' => $request->name,
                'image' => $imageName,
                'status' => $request->status,
            ]);

            return $this->success(200, 'Added Brand successfully');
        }
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 404, 'Error');
        } else {
            if ($request->hasFile('image')) {
                if ($brand->image) {
                    File::delete(public_path('uploads/brands/' . $brand->image));
                }
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('uploads/brands'), $imageName);
                $brand->image = $imageName;
            }
            $brand->name = $request->name;
            $brand->status = $request->status;
            $brand->save();
        }
        return $this->success(200, 'Updated Brand successfully');
    }

    public function destroy(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        if ($brand->image) {
            File::delete(public_path('uploads/brands/' . $brand->image));
        }

        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully.');
    }

    public function changeStatus($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->status = $brand->status == 'Active' ? 'Inactive' : 'Active';
        $brand->save();
        return response()->json([
            "status" => "Success",
            "message" => "Status updated successfully",
            "newStatus" => $brand->status
        ]);
    }
}
