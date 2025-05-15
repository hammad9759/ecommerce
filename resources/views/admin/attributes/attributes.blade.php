@extends('admin.layout')

@section('title', 'Manage Sizes')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Attributes</div>
                <div class="ms-auto">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAttributeModal">
                        <i class="lni lni-circle-plus"></i> Add New attribute
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attributes as $index => $attribute)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $attribute->name }}</td>
                                    <td>{{ $attribute->slug }}</td>
                                    <td>
                                        <a href="{{ route('admin.attributes.status', $attribute->id) }}" class="toggle-status">
                                            <span class="badge {{ $attribute->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $attribute->status }}
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editAttributesModal_{{ $attribute->id }}">
                                            <i class="bx bxs-edit"></i>
                                        </button>

                                        <form action="{{ route('admin.attributes.delete', $attribute->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                                                <i class="bx bxs-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editAttributesModal_{{ $attribute->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form class="ButtonPressJquery" action="{{ route('admin.attributes.update', $attribute->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Attributes</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Attributes</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $attribute->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="title" class="form-label">Slug</label>
                                                        <input type="text" name="slug" class="form-control" id="slug" value="{{ $attribute->slug }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select name="status" class="form-control">
                                                            <option value="Active" {{ $attribute->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                            <option value="Inactive" {{ $attribute->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </div>
                                                    <span id="SubmitButton">
                                                        <input type="submit" class="btn btn-primary px-4" value="Save Changes">
                                                    </span>
                                                </div>
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
    <div class="modal fade" id="addAttributeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Attribute</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ButtonPressJquery" action="{{ route('admin.attributes.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="name" class="form-control" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control" id="slug" required>
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
                        <a href="{{ route('admin.attributes.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
