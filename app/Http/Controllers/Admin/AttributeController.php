<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Traits\ApiResponse;
use Validator;

class AttributeController extends Controller
{

    use ApiResponse;

    public function index()
    {
        $attributes = Attribute::all();
        return view('admin.attributes.attributes', compact('attributes'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(),404,'Error');
        }else{
            Attribute::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status
            ]);
            return $this->success(200,'Attribute added successfully');
        }
    }

    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:25|unique:sizes,name,' . $id,
            'slug' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);
        if ($validation->fails()) {
            return $this->error($validation->errors()->first(),404,'Error');
        }else{
            $attribute->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status
            ]);
            return $this->success(200,'Attribute Updated successfully');
        }
    }

    public function destroy($id)
    {
        Attribute::findOrFail($id)->delete();
        return redirect()->route('admin.attributes.index')->with('success', 'Attribute deleted successfully');
    }

    public function changeStatus($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->status = $attribute->status == 'Active' ? 'Inactive' : 'Active';
        $attribute->save();

        return response()->json([
            "status" => "Success",
            "message" => "Status updated successfully",
            "newStatus" => $attribute->status
        ]);
    }

}
