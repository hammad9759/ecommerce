@extends('admin/layout')

@section('title')
    Add Products
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
                        <li class="breadcrumb-item active" aria-current="page">New product</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Settings</button>
                    <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                    </div>
                </div>
            </div>
        </div>

      
        <div class="card">
          <div class="card-body p-4">
              <h5 class="card-title">Add New Product</h5>
              <hr/>
               <div class="form-body mt-4">
                <div class="container">
                    <h1>Create New Product</h1>
                    <form class="ButtonPressJquery"  action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        
                        <!-- product image -->
                        <div class="form-group">
                            <label for="image">image</label>
                            <input type="file" name="image" id="image" class="form-control" required>
                        </div>

                        <!-- Item Code -->
                        <div class="form-group">
                            <label for="item_code">Product Item Code</label>
                            <input type="text" name="item_code" id="item_code" class="form-control" required>
                        </div>

                        <!-- keywords -->
                        <div class="form-group">
                            <label for="keywords">Product keywords</label>
                            <input type="text" name="keywords" id="keywords" class="form-control" required>
                        </div>
                        
                        <!-- description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                        </div>

                        <!-- Category -->
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">Select category</option>
                                @foreach($categories as $category)
                                    @if($category->parent_id === null)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @include('admin.products.partials.child-categories', ['childCategories' => $category->children, 'prefix' => '--'])
                                    @endif
                                @endforeach
                            </select>
                        </div>
                
                        <!-- Container to show attributes -->
                        <div id="attributesContainerRelatedToCategory" class="form-group"></div>

                        <!-- Brand -->
                        <div class="form-group">
                            <label for="brand_id">Brand</label>
                            <select name="brand_id" id="brand_id" class="form-control" required>
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                
                        <!-- Tax -->
                        <div class="form-group">
                            <label for="tax_id">Tax</label>
                            <select name="tax_id" id="tax_id" class="form-control" required>
                                @foreach($taxes as $tax)
                                    <option value="{{ $tax->id }}">{{ $tax->name }} ({{ $tax->rate }}%)</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select" id="status" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        
                        <!-- Stock -->
                        <div class="mb-3">
                            <label for="stock_status" class="form-label">Stock</label>
                            <select name="stock_status" class="form-select" id="stock_status" required>
                                <option value="In Stock">In Stock</option>
                                <option value="Out of Stock">Out of Stock</option>
                            </select>
                        </div>



                                            
                        <label>Product Attributes</label>
                        <br>
                        <br>
                        <!-- Attribute Selection Container (Populated by AJAX) -->
                        <div id="productAttributesWighImages"></div>
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
