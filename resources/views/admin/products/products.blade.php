@extends('admin/layout')

@section('title')
    Products
@endsection

@section('content')


		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Products</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Products Table</li>
							</ol>
						</nav>
					</div>
                    <div class="ms-auto">
                        <a href="{{route('admin.products.create')}}" type="button" class="btn btn-primary"> <i class="lni lni-circle-plus"></i> Add New Product </a>
                    </div>

				</div>
				<!--end breadcrumb-->


				<h6 class="mb-0 text-uppercase"></h6>
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Main Image</th>
                                        <th>Name</th>
                                        <th>SKU</th>
                                        <th>Stock</th>
                                        <th>Price</th>
                                        <th>Categories</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $index => $product)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <img src="{{ asset('uploads/products/' . $product->image) }}" alt="product" class="img-thumbnail" width="100">
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>
                                                @foreach ($product->productAttrs as $list)
                                                {{$list->sku}}
                                                @endforeach
                                            </td>
                                            
                                            <td class="align-middle">
                                                <a href="{{ route('admin.products.stockStatus', $product->id) }}" class="toggle-status"><span class="badge {{ $product->stock_status == 'In Stock' ? 'bg-success' : 'bg-danger' }}"> {{ $product->stock_status }} </span></a>
                                            </td>
                                            
                                            <td>
                                                @foreach ($product->productAttrs as $list)
                                                    {{ number_format($list->mrp, 2) }} /
                                                    {{ number_format($list->price, 2) }}
                                                @endforeach

                                            </td>
                                            <td>
                                                @foreach($product->category->ancestors() as $ancestor)
                                                    {{ $ancestor->name }} >
                                                @endforeach
                                                {{ $product->category->name }}
                                            </td>
                                            
                                            <td class="align-middle">
                                                <a href="{{ route('admin.products.status', $product->id) }}" class="toggle-status"><span class="badge {{ $product->status == 'Active' ? 'bg-success' : 'bg-danger' }}"> {{ $product->status }} </span></a>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="bx bxs-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bx bxs-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
						</div>
					</div>
				</div>
			</div>
		</div>



@endsection


