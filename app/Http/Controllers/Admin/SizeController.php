<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Size;
use Validator;

class SizeController extends Controller {

    use ApiResponse;

    // Display all sizes
    public function index() {
        $sizes = Size::all();
        return view('admin.sizes.sizes', compact('sizes'));
    }

    // Store a new size
    public function store(Request $request) {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:10|unique:sizes,name',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(),404,'Error');
        }else{
            Size::create([
                'name' => strtoupper($request->name),
                'status' => $request->status
            ]);
            return $this->success(200,'Added Banner successfully');
        }

    }

    // Update an existing size
    public function update(Request $request, $id) {
        $size = Size::findOrFail($id);

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:10|unique:sizes,name,' . $id,
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(),404,'Error');
        }else{
            $size->update([
                'name' => strtoupper($request->name),
                'status' => $request->status
            ]);
            return $this->success(200,'Added Banner successfully');
        }

    }

    // Delete a size
    public function destroy($id) {
        $size = Size::findOrFail($id);
        $size->delete();
        return redirect()->route('admin.sizes.index')->with('success', 'Size deleted successfully.');
    }

    // Change status
    public function changeStatus($id)
    {
        $size = Size::findOrFail($id);
        $size->status = $size->status === "Active" ? "Inactive" : "Active";
        $size->save();

        return response()->json([
            "status" => "Success",
            "message" => "Status updated successfully",
            "newStatus" => $size->status
        ]);
    }

}
