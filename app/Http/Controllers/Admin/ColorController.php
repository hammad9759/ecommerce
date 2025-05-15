<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use Validator;
use App\Traits\ApiResponse;

class ColorController extends Controller
{
    use ApiResponse;

    // List all colors
    public function index()
    {
        $colors = Color::all();
        return view('admin.colors.color', compact('colors'));
    }

    // Store new color
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'hexCode' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 404, 'Error');
        } else {
            Color::create([
                'name' => $request->name,
                'hexCode' => $request->hexCode,
                'status' => $request->status
            ]);
            return $this->success(200, 'Added Color successfully');
        }
    }

    // Update color
    public function update(Request $request, $id)
    {
        $color = Color::findOrFail($id);

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'hexCode' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 404, 'Error');
        } else {
            $color->name = $request->name;
            $color->hexCode = $request->hexCode;
            $color->status = $request->status;
            $color->save();
            return $this->success(200, 'Updated Color successfully');
        }
    }

    // Delete color
    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        return redirect()->route('admin.colors.index')->with('success', 'Color deleted successfully.');
    }

    // Change status
    public function changeStatus($id)
    {
        $color = Color::findOrFail($id);
        $color->status = $color->status == 'Active' ? 'Inactive' : 'Active';
        $color->save();

        return response()->json([
            "status" => "Success",
            "message" => "Status updated successfully",
            "newStatus" => $color->status
        ]);
    }

}
