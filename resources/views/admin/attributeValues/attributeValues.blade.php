@extends('admin.layout')

@section('title', 'Manage Sizes')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Sizes</div>
                <div class="ms-auto">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAttributeValuesModal">
                        <i class="lni lni-circle-plus"></i> Add New Attribute Value
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Attribute Value</th>
                                <th>Attribute</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attributeValues as $index => $attributeValue)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $attributeValue->value }}</td>
                                    <td>{{ $attributeValue->attribute->name }}</td>
                                    <td>
                                        <a href="{{ route('admin.attributeValues.status', $attributeValue->id) }}" class="toggle-status">
                                            <span class="badge {{ $attributeValue->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $attributeValue->status }}
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editAttributeValueseModal_{{ $attributeValue->id }}">
                                            <i class="bx bxs-edit"></i>
                                        </button>

                                        <form action="{{ route('admin.attributeValues.delete', $attributeValue->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                                                <i class="bx bxs-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal Attribute Valuese -->
                                <div class="modal fade" id="editAttributeValueseModal_{{ $attributeValue->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form class="ButtonPressJquery" action="{{ route('admin.attributeValues.update', $attributeValue->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Attribute Values</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Attribute Values</label>
                                                        <input type="text" name="value" class="form-control" value="{{ $attributeValue->value }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="attribute_id" class="form-label">Attribute</label>
                                                        <select name="attribute_id" class="form-control" required>
                                                            <option value="">Select Attribute</option>
                                                            @foreach ($attributes as $attribute)
                                                                <option value="{{ $attribute->id }}" {{ $attribute->id == $attributeValue->attribute_id ? 'selected' : '' }}>
                                                                    {{ $attribute->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select name="status" class="form-control">
                                                            <option value="Active" {{ $attributeValue->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                            <option value="Inactive" {{ $attributeValue->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
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
    <div class="modal fade" id="addAttributeValuesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create AddAttribute Values</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ButtonPressJquery" action="{{ route('admin.attributeValues.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">AddAttribute Value</label>
                            <input type="text" name="value" class="form-control" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="attribute_id" class="form-label">Attribute</label>
                            <select name="attribute_id" class="form-control" required>
                                <option value="">Select Attribute</option>
                                @foreach ($attributes as $attribute)
                                    <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                @endforeach
                            </select>
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
                        <a href="{{ route('admin.attributeValues.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
