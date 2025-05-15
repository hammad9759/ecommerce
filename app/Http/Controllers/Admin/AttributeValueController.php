<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\Attribute;
use App\Traits\ApiResponse;
use Validator;

class AttributeValueController extends Controller
{

    use ApiResponse;

    public function index()
    {
        $attributeValues = AttributeValue::with('attribute')->get();
        $attributes = Attribute::where('status', 'Active')->get();
        return view('admin.attributeValues.attributeValues', compact('attributeValues', 'attributes'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(),404,'Error');
        }else{
            AttributeValue::create($request->all());
            return $this->success(200,'Attribute added successfully');
        }
    }

    // Update an existing size
    public function update(Request $request, $id) {
        $value = AttributeValue::findOrFail($id);
        $validation = Validator::make($request->all(), [
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);
        if ($validation->fails()) {
            return $this->error($validation->errors()->first(),404,'Error');
        }else{
            $value->update([
                'attribute_id' => strtoupper($request->attribute_id),
                'value' => strtoupper($request->value),
                'status' => $request->status
            ]);
            return $this->success(200,'Attribute Value Updated successfully');
        }
    }

    public function destroy($id)
    {
        AttributeValue::findOrFail($id)->delete();
        return redirect()->route('admin.attributeValues.index')->with('success', 'Attribute value deleted successfully');
    }

    public function changeStatus($id)
    {
        $value = AttributeValue::findOrFail($id);
        $value->status = $value->status == 'Active' ? 'Inactive' : 'Active';
        $value->save();

        return response()->json([
            "status" => "Success",
            "message" => "Status updated successfully",
            "newStatus" => $value->status
        ]);
    }
}
