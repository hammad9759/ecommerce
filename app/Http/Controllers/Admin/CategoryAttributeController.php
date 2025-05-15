<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Attribute;
use App\Models\CategoryAttribute;



class CategoryAttributeController extends Controller
{
    public function index()
    {
        $categoryAttributes = CategoryAttribute::with('category', 'attribute')->get();
        $categories = Category::all();
        $attributes = Attribute::all();

        return view('admin.categoryAttributes.categoryAttributes', compact('categoryAttributes', 'categories', 'attributes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'attribute_id' => 'required|exists:attributes,id',
        ]);

        CategoryAttribute::create($request->all());

        return redirect()->route('admin.categoryAttributes.index')->with('success', 'Category Attribute added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'attribute_id' => 'required|exists:attributes,id',
        ]);

        $categoryAttribute = CategoryAttribute::findOrFail($id);
        $categoryAttribute->update($request->all());

        return redirect()->route('admin.categoryAttributes.index')->with('success', 'Category Attribute updated successfully.');
    }

    public function destroy($id)
    {
        CategoryAttribute::destroy($id);

        return redirect()->route('admin.categoryAttributes.index')->with('success', 'Category Attribute deleted successfully.');
    }

}
