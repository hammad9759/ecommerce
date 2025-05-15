<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Validator;
use Str;

class CategoryController extends Controller {
    use ApiResponse;

    // Display all categories
    public function index() {
        $categories = Category::with('parent')->get();
        return view('admin.categories.categories', compact('categories'));
    }

    // Store a new category
    public function store(Request $request) {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 404, 'Error');
        }

        // Upload Image
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/categories'), $imageName);
        } else {
            $imageName = null;
        }

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'image' => $imageName,
            'status' => $request->status,
        ]);

        return $this->success(200, 'Category added successfully');
    }

    // Update an existing category
    public function update(Request $request, $id) {
        $category = Category::findOrFail($id);

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 404, 'Error');
        }
        // Update Image if uploaded
        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image) {
                File::delete(public_path('uploads/categories/' . $category->image));
            }
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/categories'), $imageName);
            $category->image = $imageName;
        }else {
            $imageName = $category->image;
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'image' => $imageName,
            'status' => $request->status,
        ]);

        return $this->success(200, 'Category updated successfully');
    }

    // Delete a category
    public function destroy($id) {
        $category = Category::findOrFail($id);
        // Delete image file
        if ($category->image) {
            File::delete(public_path('uploads/categories/' . $category->image));
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

    // Change category status
    public function changeStatus($id) {
        $category = Category::findOrFail($id);
        $category->status = $category->status === "Active" ? "Inactive" : "Active";
        $category->save();

        return response()->json([
            "status" => "Success",
            "message" => "Status updated successfully",
            "newStatus" => $category->status
        ]);
    }
}
