<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\File;
use Validator;
use Illuminate\Support\Str;

use App\Models\Category;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\CategoryAttribute;
use App\Models\Size;
use App\Models\Color;
use App\Models\Brand;
use App\Models\Tax;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttr;
use App\Models\ProductAttrImage;

class ProductController extends Controller
{
    use ApiResponse;

    public function index()    {
        $products = Product::with('productAttrs', 'category.parent')->get();
        // prx($products);
        return view('admin.products.products', compact('products'));
    }

    public function create(){
        // Fetch all necessary data for the form
        $categories = Category::where('status', 'Active')->get();
        $attributes = Attribute::with('values')->where('status', 'Active')->get();
        $sizes = Size::where('status', 'Active')->get();
        $colors = Color::where('status', 'Active')->get();
        $brands = Brand::where('status', 'Active')->get();
        $taxes = Tax::where('status', 'Active')->get();

        // Pass the data to the view
        return view('admin.products.addProduct', compact('categories', 'attributes', 'sizes', 'colors', 'brands', 'taxes'));
    }
    

    public function getAttributesById(Request $request){
        $categoryId = $request->category_id;
        $data = CategoryAttribute::where('category_id',$categoryId)->with('attribute')->get();
        $message = 'category_id = '. $categoryId .' having these attributes and values';
        return $this->success($data, $message);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'item_code' => 'required|string|max:255',
            'keywords' => 'nullable|string',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'tax_id' => 'nullable|exists:taxes,id',
            'status' => 'required|in:Active,Inactive',
            'stock_status' => 'required|in:In Stock,Out of Stock',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
        } else {
            $imageName = null;
        }

        // Step 1: Insert into products table
        $product = Product::create([
            'name' => $validatedData['name'],
            'slug' => \Str::slug($validatedData['name']),
            'image' => $imageName,
            'item_code' => $validatedData['item_code'],
            'keywords' => $validatedData['keywords'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
            'brand_id' => $validatedData['brand_id'],
            'tax_id' => $validatedData['tax_id'],
            'status' => $validatedData['status'],
            'stock_status' => $validatedData['stock_status'],
        ]);

        // Step 2: Insert into product_attributes table
        foreach ($request->attribute_id as $key => $attributeId) {
            ProductAttribute::create([
                'product_id' => $product->id,
                'category_id' => $request->category_id,
                'attribute_value_id' => $attributeId,
            ]);
        }

        // Step 3: Insert into product_attrs table
        $productAttrIds = [];
        for ($i = 0; $i < count($request->sku); $i++) {
            $productAttr = ProductAttr::create([
                'product_id' => $product->id,
                'color_id' => $request->color_id[$i],
                'size_id' => $request->size_id[$i],
                'sku' => $request->sku[$i],
                'mrp' => $request->mrp[$i],
                'price' => $request->price[$i],
                'qty' => $request->qty[$i],
                'length' => $request->length[$i],
                'breadth' => $request->breadth[$i],
                'height' => $request->height[$i],
                'weight' => $request->weight[$i],
            ]);
            $productAttrIds[] = $productAttr->id;

            // Step 4: Handle images
            $imageKey = 'images_' . ($i + 1);
            if ($request->hasFile($imageKey)) {
                foreach ($request->file($imageKey) as $imageddr) {
                    $imageName2 = uniqid($imageKey . '_') . '.' . $imageddr->extension();
                    $imageddr->move(public_path('uploads/products/attribute_images'), $imageName2);            
                    ProductAttrImage::create([
                        'product_id' => $product->id,
                        'product_attr_id' => $productAttr->id,
                        'image' => $imageName2,
                    ]);
                }
            }
        }
        return $this->success(200,'Added Product successfully');
    
    }

    public function edit($id) {
        $product = Product::with(['productAttrs.AttrImages', 'attributes.attributeValue.attribute', 'brand', 'tax'])->findOrFail($id);

        $categories = Category::where('status', 'Active')->get();
        $CategoryAttribute = CategoryAttribute::where('category_id',$product->category_id)->with('attribute')->get();
        $sizes = Size::where('status', 'Active')->get();
        $colors = Color::where('status', 'Active')->get();
        $brands = Brand::where('status', 'Active')->get();
        $taxes = Tax::where('status', 'Active')->get();
        $otherAttributes = Attribute::with('values')->where('status', 'Active')->get();
    
        // prx($product->productAttrs->toArray());
        
        return view('admin.products.editProduct', compact('product', 'CategoryAttribute', 'categories', 'otherAttributes', 'sizes', 'colors', 'brands', 'taxes'));
    }
    
    public function update(Request $request, $id) {
        // Step 1: Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'item_code' => 'required|string|unique:products,item_code,' . $id,
            'keywords' => 'nullable|string',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'tax_id' => 'nullable|exists:taxes,id',
            'status' => 'required|in:Active,Inactive',
            'stock_status' => 'required|in:In Stock,Out of Stock',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
    
        // Step 2: Find the product to update
        $product = Product::findOrFail($id);
    
        // Step 3: Handle product image update
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
                unlink(public_path('uploads/products/' . $product->image));
            }
            // Upload the new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
        }
    
        // Step 4: Update product details
        $product->update([
            'name' => $validatedData['name'],
            'slug' => \Str::slug($validatedData['name']),
            'item_code' => $validatedData['item_code'],
            'keywords' => $validatedData['keywords'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
            'brand_id' => $validatedData['brand_id'],
            'tax_id' => $validatedData['tax_id'],
            'status' => $validatedData['status'],
            'stock_status' => $validatedData['stock_status'],
            'image' => $product->image, // Updated or existing image
        ]);
    
        // Step 5: Update or create product attributes
        if ($request->has('attribute_id')) {
            // Delete existing product attributes
            ProductAttribute::where('product_id', $product->id)->delete();
    
            // Insert new product attributes
            foreach ($request->attribute_id as $attributeId) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'category_id' => $request->category_id,
                    'attribute_value_id' => $attributeId,
                ]);
            }
        }
    
        // Step 6: Update or create product attributes details (product_attrs)
        if ($request->has('sku')) {
            // Fetch existing product attributes details
            $existingProductAttrs = ProductAttr::where('product_id', $product->id)->get();
    
            // Delete existing product attribute images and their files
            foreach ($existingProductAttrs as $existingProductAttr) {
                // Fetch all images for the current product attribute
                $images = ProductAttrImage::where('product_attr_id', $existingProductAttr->id)->get();
    
                // Delete physical image files
                foreach ($images as $image) {
                    if (file_exists(public_path('uploads/products/attribute_images/' . $image->image))) {
                        unlink(public_path('uploads/products/attribute_images/' . $image->image));
                    }
                }
    
                // Delete image records from the database
                ProductAttrImage::where('product_attr_id', $existingProductAttr->id)->delete();
            }
    
            // Delete existing product attributes details
            ProductAttr::where('product_id', $product->id)->delete();
    
            // Insert new product attributes details
            for ($i = 0; $i < count($request->sku); $i++) {
                $productAttr = ProductAttr::create([
                    'product_id' => $product->id,
                    'color_id' => $request->color_id[$i],
                    'size_id' => $request->size_id[$i],
                    'sku' => $request->sku[$i],
                    'mrp' => $request->mrp[$i],
                    'price' => $request->price[$i],
                    'qty' => $request->qty[$i],
                    'length' => $request->length[$i],
                    'breadth' => $request->breadth[$i],
                    'height' => $request->height[$i],
                    'weight' => $request->weight[$i],
                ]);
    
                // Step 7: Handle product attribute images
                $imageKey = 'images_' . ($i + 1);
                if ($request->hasFile($imageKey)) {
                    // Upload and insert new images
                    foreach ($request->file($imageKey) as $imageddr) {
                        $imageName2 = uniqid($imageKey . '_') . '.' . $imageddr->extension();
                        $imageddr->move(public_path('uploads/products/attribute_images'), $imageName2);
                        ProductAttrImage::create([
                            'product_id' => $product->id,
                            'product_attr_id' => $productAttr->id,
                            'image' => $imageName2,
                        ]);
                    }
                }
            }
        }
    
        return $this->success(200, 'Product updated successfully');
    }

    public function destroy($id) {
        $product = Product::findOrFail($id);
    
        // Delete the main product image
        if ($product->image) {
            File::delete(public_path('uploads/products/' . $product->image));
        }
    
        // Delete attribute images associated with the product
        $attributeImages = ProductAttrImage::where('product_id', $id)->get();
        foreach ($attributeImages as $attrImage) {
            if ($attrImage->image) {
                File::delete(public_path('uploads/products/attribute_images/' . $attrImage->image));
            }
            $attrImage->delete();
        }
    
        // Delete the product itself
        $product->delete();
    
        return redirect()->route('admin.products.index')->with('success', 'Product and associated attribute images deleted successfully.');
    }
    

    public function changeStockStatus($id){
        $product = Product::findOrFail($id);
        $product->stock_status = $product->stock_status === 'In Stock' ? 'Out of Stock' : 'In Stock';
        $product->save();

        return response()->json([
            "status" => "Success",
            "message" => "Stock status updated successfully",
            "newStatus" => $product->stock_status
        ]);
    }

    public function changeStatus($id){
        $product = Product::findOrFail($id);
        $product->status = $product->status === 'Active' ? 'Inactive' : 'Active';
        $product->save();

        return response()->json([
            "status" => "Success",
            "message" => "Status updated successfully",
            "newStatus" => $product->status
        ]);
    }
}
