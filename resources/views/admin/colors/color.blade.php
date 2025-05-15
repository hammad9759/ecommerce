@extends('admin/layout')

@section('title')
    Colors
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Colors</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Colors</li>
                        </ol>
                    </nav>
                </div>

                <div class="ms-auto">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addColorModal">
                        <i class="lni lni-circle-plus"></i> Add New Color
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Color Name</th>
                                    <th>Color</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($colors as $index => $color)
                                    <tr class="align-middle">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $color->name }}</td>
                                        <td><div class="chip chip-md m-0" style="background-color: #{{ $color->hexCode }}"> <span class="bg-white rounded-4 px-2">#{{ $color->hexCode }}</span> </div></td>
                                        <td>
                                            <a href="{{ route('admin.colors.status', $color->id) }}"  class="toggle-status">
                                                <span class="badge {{ $color->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $color->status }}
                                                </span>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editColorModal_{{ $index + 1 }}">
                                                <i class="bx bxs-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.colors.delete', $color->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this color?');">
                                                    <i class="bx bxs-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Color Modal -->
                                    <div class="modal fade" id="editColorModal_{{ $index + 1 }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Color</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="ButtonPressJquery" action="{{ route('admin.colors.update', $color->id) }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Color Name</label>
                                                            <input type="text" name="name" class="form-control" value="{{ $color->name }}" required>
                                                        </div>
                                                        <div class="mb-3 d-flex gap-2 align-items-center">
                                                            <input type="text" class="form-control colorCode" name="hexCode" value="#{{ $color->hexCode }}" required>
                                                            <input type="color" class="w-25 form-control colorPicker" value="#{{ $color->hexCode }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select name="status" class="form-control">
                                                                <option value="Active" {{ $color->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                                <option value="Inactive" {{ $color->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </div>
                                                        <span id="SubmitButton">
                                                            <input type="submit" class="btn btn-primary px-4" value="Save Changes">
                                                        </span>
                                                    </form>
                                                </div>
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
    </div>


    <!-- Add new color Modal -->
    <div class="modal fade" id="addColorModal" tabindex="-1" aria-labelledby="addColorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addColorModalLabel">Create Color</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="ButtonPressJquery" action="{{ route('admin.colors.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="name" class="form-control" id="title" required>
                        </div>
                        <div class="mb-3 d-flex gap-2 align-items-center">
                            <input type="text" class="form-control colorCode" name="hexCode" placeholder="#123456" required>
                            <input type="color" class="w-25 form-control colorPicker" required>
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
                        <a href="{{ route('admin.colors.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll(".colorPicker").forEach((picker, index) => {
            const colorCode = document.querySelectorAll(".colorCode")[index];

            // Update text input when color picker changes
            picker.addEventListener("input", function() {
                colorCode.value = picker.value.replace("#", "");
            });

            // Update color picker when user enters a valid hex color
            colorCode.addEventListener("input", function() {
                let cleanValue = colorCode.value.replace(/[^0-9A-Fa-f]/g, ""); // Remove invalid characters
                if (/^([0-9A-F]{3}|[0-9A-F]{6})$/i.test(cleanValue)) {
                    picker.value = "#" + cleanValue;
                }
            });
        });
    </script>

@endsection
