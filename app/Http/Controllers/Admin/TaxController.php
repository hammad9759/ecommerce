<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tax;
use App\Traits\ApiResponse;
use Validator;

class TaxController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $taxes = Tax::all();
        return view('admin.taxes.taxes', compact('taxes')); // Adjust view path as needed
    }

    public function pro()
    {
        return view('admin.products.products');
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
            'type' => 'required|in:percentage,fixed',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 422, 'Validation Error');
        }

        Tax::create([
            'name' => $request->name,
            'rate' => $request->rate,
            'type' => $request->type,
            'status' => $request->status
        ]);

        return $this->success(201, 'Tax created successfully');
    }

    public function update(Request $request, $id)
    {
        $tax = Tax::findOrFail($id);

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
            'type' => 'required|in:percentage,fixed',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 422, 'Validation Error');
        }

        $tax->update([
            'name' => $request->name,
            'rate' => $request->rate,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return $this->success(200, 'Tax updated successfully');
    }

    public function destroy($id)
    {
        $tax = Tax::findOrFail($id);
        $tax->delete();

        return redirect()->route('admin.taxes.index')->with('success', 'Tax deleted successfully');
    }

    // Change status
    public function changeStatus($id)
    {
        $tax = Tax::findOrFail($id);
        $tax->status = $tax->status === "Active" ? "Inactive" : "Active";
        $tax->save();

        return response()->json([
            "status" => "Success",
            "message" => "Status updated successfully",
            "newStatus" => $tax->status
        ]);
    }
}
