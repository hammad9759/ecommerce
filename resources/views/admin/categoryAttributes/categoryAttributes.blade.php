@extends('admin.layout')

@section('title', 'Manage Category Attributes')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Category Attributes</div>
            <div class="ms-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryAttributeModal">
                    <i class="lni lni-circle-plus"></i> Add New Category Attribute
                </button>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Attribute</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categoryAttributes as $index => $categoryAttribute)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $categoryAttribute->category->name }}</td>
                                <td>
                                    @foreach($categoryAttribute->attribute as $attribute)
                                    {{ $attribute->name }}
                                @endforeach
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal_{{ $categoryAttribute->id }}">
                                        <i class="bx bxs-edit"></i>
                                    </button>

                                    <form action="{{ route('admin.categoryAttributes.delete', $categoryAttribute->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                                            <i class="bx bxs-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal_{{ $categoryAttribute->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.categoryAttributes.update', $categoryAttribute->id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Category Attribute</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label>Category</label>
                                                    <select name="category_id" class="form-control">
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}" {{ $categoryAttribute->category_id == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Attribute</label>
                                                    <select name="attribute_id" class="form-control">
                                                        @foreach ($attributes as $attribute)
                                                            <option value="{{ $attribute->id }}" {{ $categoryAttribute->attribute_id == $attribute->id ? 'selected' : '' }}>
                                                                {{ $attribute->name }}
                                                            </option>
                                                        @endforeach
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

<!-- Add Modal -->
<div class="modal fade" id="addCategoryAttributeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.categoryAttributes.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Category Attribute</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Category</label>
                        <select name="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Attribute</label>
                        <select name="attribute_id" class="form-control">
                            @foreach ($attributes as $attribute)
                                <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <span id="SubmitButton">
                        <input type="submit" class="btn btn-primary px-4" value="Save Changes">
                    </span>

                    <a href="{{ route('admin.homeBanner') }}" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
