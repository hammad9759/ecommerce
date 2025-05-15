@extends('admin/layout')

@section('title')
    Brands
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Brands</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Brands</li>
                        </ol>
                    </nav>
                </div>

                <div class="ms-auto">
                    <div class="btn">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBrandModal"><i class="lni lni-circle-plus"></i> Add new Brand</button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Brand Image</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $index => $brand)
                                    <tr>
                                        <td class="align-middle">{{ $index + 1 }}</td>
                                        <td class="align-middle">
                                            <img src="{{ asset('uploads/brands/' . $brand->image) }}" alt="Brand" class="img-thumbnail" width="100">
                                        </td>
                                        <td class="align-middle">{{ $brand->name }}</td>
                                        <td class="align-middle">
                                            <a href="{{ route('admin.brands.status', $brand->id) }}" class="toggle-status"><span class="badge {{ $brand->status == 'Active' ? 'bg-success' : 'bg-danger' }}"> {{ $brand->status }} </span></a>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex order-actions">
                                                <a href="#" data-bs-toggle="modal" class="btn btn-primary btn-sm m-2" data-bs-target="#editBrandModal_{{ $index + 1 }}" > <i class="bx bxs-edit"></i> </a>

                                                <form action="{{ route('admin.brands.delete', $brand->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm m-2" onclick="return confirm('Are you sure you want to delete this brand?');">
                                                        <i class="bx bxs-trash"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="editBrandModal_{{ $index + 1 }}" tabindex="-1" aria-labelledby="editBrandModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editBrandModalLabel">Edit Brand</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="ButtonPressJquery" action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf

                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" name="name" class="form-control" id="name" value="{{ $brand->name }}" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="image" class="form-label">Upload Brand Image</label>
                                                            <input type="file" name="image" class="form-control" id="image" accept="image/*" onchange="previewImage(event)">
                                                            <img src="{{ asset('uploads/brands/' . $brand->image) }}" alt="Brand" class="my-2 img-thumbnail preview" width="100">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select name="status" class="form-select" id="status" required>
                                                                <option value="Active" {{ $brand->status == 'Active' ? 'selected' : ' ' }}>Active</option>
                                                                <option value="Inactive" {{ $brand->status == 'Active' ? ' ' : 'selected' }}>Inactive</option>
                                                            </select>
                                                            <a ><span class="badge "> {{ $brand->status }} </span></a>
                                                        </div>

                                                        <span id="SubmitButton">
                                                            <input type="submit" class="btn btn-primary px-4" value="Save Changes">
                                                        </span>

                                                        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Back</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addBrandModalLabel">Create Brand</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="ButtonPressJquery" action="{{ route('admin.brands.store') }}" method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" name="name" class="form-control" id="name" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="image" class="form-label">Upload Brand Image</label>
                                                <input type="file" name="image" class="form-control" id="image" accept="image/*" onchange="previewImage(event)" required>
                                                <img src="" alt="Brand" class="my-2 img-thumbnail preview" width="100">
                                            </div>

                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" class="form-select" id="status" required>
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                            </div>
                                            <span id="SubmitButton">
                                                <input type="submit" class="btn btn-primary px-4" value="Save Changes">
                                            </span>
                                            <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Back</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
