@extends('admin/layout')

@section('title')
    Edit Products
@endsection

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">eCommerce</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit product</li>
                    </ol>
                </nav>
            </div>
            
        </div>

      
        <div class="card">
          <div class="card-body p-4">
              <h5 class="card-title">Add New Product</h5>
              <hr/>
               <div class="form-body mt-4">
                <div class="container">
                    <h1>Edit Product</h1>
                    <form class="ButtonPressJquery"  action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" name="name" id="name" class="form-control" required value="{{$product->name}}">
                        </div>
                        
                        <!-- product image -->
                        <div class="form-group">
                            <label for="image">image</label>
                            <input type="file" name="image" id="image" class="form-control">
                            <img src="{{ asset('uploads/products/' . $product->image) }}" alt="" srcset="" class="img-thumbnail my-2 preview w-25 my-2">
                            
                        </div>

                        <!-- Item Code -->
                        <div class="form-group">
                            <label for="item_code">Product Item Code</label>
                            <input type="text" name="item_code" id="item_code" class="form-control" required value="{{$product->item_code}}">
                        </div>

                        <!-- keywords -->
                        <div class="form-group">
                            <label for="keywords">Product keywords</label>
                            <input type="text" name="keywords" id="keywords" class="form-control" required value="{{$product->keywords}}">
                        </div>
                        
                        <!-- description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="3">{{$product->description}}</textarea>
                        </div>

                        <!-- Category -->
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">Select category</option>
                                @foreach($categories as $category)
                                    @if($category->parent_id === null)
                                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @include('admin.products.partials.child-categoriesEdit', ['childCategories' => $category->children, 'prefix' => '--'])
                                    @endif
                                @endforeach
                            </select>
                        </div>
                            
                        <div id="attributesContainerRelatedToCategory" class="form-group">
                            @foreach ($CategoryAttribute as $attribute)
                                @if (isset($attribute['attribute'][0]['name']) && isset($attribute['attribute'][0]['values']))
                                    <label for="attribute_id">{{ $attribute['attribute'][0]['name'] }}</label>
                                    <select name="attribute_id[]" id="attribute_id" class="form-control" multiple="" required="">
                                        <option value="">Select {{ $attribute['attribute'][0]['name'] }}</option>
                                        @foreach ($attribute['attribute'][0]['values'] as $value)
                                            @php
                                                $isSelected = false;
                                                foreach ($product->attributes as $productAttribute) {
                                                    if ($productAttribute['attribute_value_id'] == $value['id']) {
                                                        $isSelected = true;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            <option value="{{ $value['id'] }}" {{ $isSelected ? 'selected' : '' }}>{{ $value['value'] }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            @endforeach
                        </div>

                        <!-- Brand -->
                        <div class="form-group">
                            <label for="brand_id">Brand</label>
                            <select name="brand_id" id="brand_id" class="form-control" required>
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                
                        <!-- Tax -->
                        <div class="form-group">
                            <label for="tax_id">Tax</label>
                            <select name="tax_id" id="tax_id" class="form-control" required>
                                <option value="">Select Tax</option>
                                @foreach($taxes as $tax)
                                <option value="{{ $tax->id }}"  {{ $tax->id == $product->tax_id ? 'selected' : '' }}>{{ $tax->name }} ({{ $tax->rate }}%)</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select" id="status" required>
                                <option value="">Select Status</option>
                                <option value="Active" {{ $product->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $product->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        
                        <!-- Stock -->
                        <div class="mb-3">
                            <label for="stock_status" class="form-label">Stock</label>
                            <select name="stock_status" class="form-select" id="stock_status" required>
                                <option value="">Select Stock Status</option>
                                <option value="In Stock" {{ $product->stock_status == 'In Stock' ? 'selected' : '' }}>In Stock</option>
                                <option value="Out of Stock" {{ $product->stock_status == 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>

                                            
                        <label>Product Attributes</label>
                        <br>
                        <br>

                        <!-- Attribute Selection Container (Populated by AJAX) -->
                        <div id="productAttributesWighImages">

                        @if ($product->productAttrs->isNotEmpty())
                            @foreach ($product->productAttrs as $key=> $attr)
                                <div class="row mt-3 product-attribute-row">
                                    <input type="text" name="imageValue[]" value="{{$key+1}}" class="form-control" readonly hidden>
                                    <div class="col-md-2 my-2">
                                        <select name="color_id[]" class="form-control" required>
                                            <option value="">Select Color</option>
                                            @foreach($colors as $color)
                                                <option value="{{ $color->id }}" {{ $color->id == $attr->color_id ? 'selected' : '' }} style="background-color:{{ $color->name }};">{{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 my-2">
                                        <select name="size_id[]" class="form-control" required>
                                            <option value="">Select Size</option>
                                            @foreach($sizes as $size)
                                                <option value="{{ $size->id }}" {{ $size->id == $attr->size_id ? 'selected' : '' }}>{{ $size->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 my-2">
                                        <input type="text" name="sku[]" class="form-control" placeholder="SKU" value="{{$attr->sku}}" required>
                                    </div>
                                    <div class="col-md-2 my-2">
                                        <input type="number" name="mrp[]" class="form-control" placeholder="MRP" value="{{$attr->mrp}}" required>
                                    </div>
                                    <div class="col-md-2 my-2">
                                        <input type="number" name="price[]" class="form-control" placeholder="Price" value="{{$attr->price}}" required>
                                    </div>
                                    <div class="col-md-2 my-2">
                                        <input type="number" name="qty[]" class="form-control" placeholder="Quantity" value="{{$attr->qty}}" required>
                                    </div>
                                    <div class="col-md-2 my-2">
                                        <input type="text" name="length[]" class="form-control" placeholder="Length" value="{{$attr->length}}">
                                    </div>
                                    <div class="col-md-2 my-2">
                                        <input type="text" name="breadth[]" class="form-control" placeholder="Breadth" value="{{$attr->breadth}}">
                                    </div>
                                    <div class="col-md-2 my-2">
                                        <input type="text" name="height[]" class="form-control" placeholder="Height" value="{{$attr->height}}">
                                    </div>
                                    <div class="col-md-2 my-2">
                                        <input type="text" name="weight[]" class="form-control" placeholder="Weight" value="{{$attr->weight}}">
                                    </div>
                                    <div class="col-md-4 my-2">
                                        <input type="file" name="images_{{$key+1}}[]" class="form-control" multiple>
                                    </div>
                                    @if ($attr->images->isNotEmpty())
                                        <p>Images:</p>
                                        <ul class="d-flex list-inline">
                                            @foreach ($attr->AttrImages as $image)
                                                <li>
                                                    <img src="{{ asset('uploads/products/attribute_images/' . $image->image) }}" alt="Image" width="100" class="m-2 img-thumbnail preview">
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    <div class="col-md-3 my-3">
                                        <button type="button" class="btn btn-danger btn-sm removeAttr">Remove</button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
    
    
                            
                            
                        </div>



                        <!-- Product Attributes -->
                        <div id="productAttributes">
                            <button type="button" id="addAttribute" class="btn btn-success btn-sm">Add Attribute</button>
                        </div>            
                        <br>
                        <br>
                        
                        <span id="SubmitButton">
                            <input type="submit" class="btn btn-primary px-4" value="Save Product">
                        </span>
                    </form>
                </div>
            </div>
          </div>
      </div>


    </div>
</div>

@endsection
