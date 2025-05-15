@extends('admin.layout')

@section('title', 'Manage Categories')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Categories</div>
                <div class="ms-auto">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="lni lni-circle-plus"></i> Add New Category
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
                                <th>Parent Category</th>
                                <th>Slug</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $index => $category)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->parent ? $category->parent->name : 'N/A' }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td><img src="{{ asset('uploads/categories/' . $category->image) }}" width="50"> </td>
                                    <td> <a href="{{ route('admin.categories.status', $category->id) }}" class="toggle-status"> <span class="badge {{ $category->status == 'Active' ? 'bg-success' : 'bg-danger' }}"> {{ $category->status }} </span> </a> </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCategoryModal_{{ $category->id }}"> <i class="bx bxs-edit"></i> </button>
                                        <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');"> <i class="bx bxs-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editCategoryModal_{{ $category->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form class="ButtonPressJquery" action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Category</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Category Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Parent Category</label>
                                                        <select name="parent_id" class="form-control">
                                                            <option value="">None</option>
                                                            @foreach ($categories as $cat)
                                                                @if ($cat->id != $category->id) <!-- Exclude the current category -->
                                                                    <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}> {{ $cat->name }} </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Slug</label>
                                                        <input type="text" name="slug" class="form-control" value="{{ $category->slug }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Image</label>
                                                        <input type="file" name="image" class="form-control" onchange="previewImage(event)">
                                                        <img src="{{ asset('uploads/categories/' . $category->image) }}" class="img-thumbnail my-2 preview" width="150">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-control">
                                                            <option value="Active" {{ $category->status == 'Active' ? 'selected' : '' }}> </option>
                                                            <option value="Inactive" {{ $category->status == 'Inactive' ? 'selected' : '' }}> Inactive</option>
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

    <!-- Add new category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form class="ButtonPressJquery" action="{{ route('admin.categories.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" id="category-name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Parent Category</label>
                            <select name="parent_id" class="form-control">
                                <option value="">None</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control" id="category-slug" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" onchange="previewImage(event)">
                            <img src="#" class="img-thumbnail my-2 preview" width="150">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <span id="SubmitButton">
                            <input type="submit" class="btn btn-primary px-4" value="Save Changes">
                        </span>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('category-name').addEventListener('input', function() {
            var name = this.value;
            // Convert name to slug
            var slug = name
                .toLowerCase()
                .replace(/\s+/g, '-') // Replace spaces with hyphens
                .replace(/[^\w\-]+/g, '') // Remove non-word characters
                .replace(/\-\-+/g, '-') // Replace multiple hyphens with a single one
                .replace(/^-+/, '') // Remove hyphens from the start
                .replace(/-+$/, ''); // Remove hyphens from the end

            document.getElementById('category-slug').value = slug;
        });
    </script>
@endsection
