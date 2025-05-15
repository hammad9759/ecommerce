@extends('admin.layout')

@section('title', 'Manage Sizes')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Sizes</div>
                <div class="ms-auto">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSizeModal">
                        <i class="lni lni-circle-plus"></i> Add New Size
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Size</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sizes as $index => $size)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $size->name }}</td>
                                    <td>
                                        <a href="{{ route('admin.sizes.status', $size->id) }}" class="toggle-status">
                                            <span class="badge {{ $size->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $size->status }}
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editSizeModal_{{ $size->id }}">
                                            <i class="bx bxs-edit"></i>
                                        </button>

                                        <form action="{{ route('admin.sizes.delete', $size->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                                                <i class="bx bxs-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editSizeModal_{{ $size->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form class="ButtonPressJquery" action="{{ route('admin.sizes.update', $size->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Size</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Size</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $size->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select name="status" class="form-control">
                                                            <option value="Active" {{ $size->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                            <option value="Inactive" {{ $size->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <span id="SubmitButton">
                                                    <input type="submit" class="btn btn-primary px-4" value="Save Changes">
                                                </span>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Add new size Modal -->
    <div class="modal fade" id="addSizeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ButtonPressJquery" action="{{ route('admin.sizes.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="name" class="form-control" id="title" required>
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
                        <a href="{{ route('admin.sizes.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
