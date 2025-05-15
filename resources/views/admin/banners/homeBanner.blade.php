@extends('admin/layout')

@section('title')
    Home Banners
@endsection

@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Home Banners</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Banners</li>
                        </ol>
                    </nav>
                </div>

                <div class="ms-auto">
                    <div class="btn">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="lni lni-circle-plus"></i> Add new Banner</button>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Banner Image</th>
                                    <th>Title</th>
                                    <th>Description & Url</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banners as $index => $banner)
                                    <tr>
                                        <td class="align-middle">{{ $index + 1 }}</td>
                                        <td class="align-middle">
                                            <img src="{{ asset('uploads/banners/' . $banner->image) }}" alt="Banner" class="img-thumbnail" width="100">
                                        </td>
                                        <td class="align-middle">{{ $banner->title }}</td>
                                        <td class="align-middle">
                                            <p>{{ $banner->description }}</p>
                                            <p><a href="{{ $banner->url }}" target="_blank">{{ $banner->url }}</a></p>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('admin.homeBanner.status', $banner->id) }}" class="toggle-status"><span class="badge {{ $banner->status == 'Active' ? 'bg-success' : 'bg-danger' }}"> {{ $banner->status }} </span></a>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex order-actions">
                                                <a href="#" data-bs-toggle="modal" class="btn btn-primary btn-sm m-2" data-bs-target="#exampleModal_{{ $index + 1 }}" > <i class="bx bxs-edit"></i> </a>

                                                <form action="{{ route('admin.homeBanner.delete', $banner->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm m-2" onclick="return confirm('Are you sure you want to delete this banner?');">
                                                        <i class="bx bxs-trash"></i>
                                                    </button>
                                                </form>

                                            </div>
                                         </td>
                                    </tr>
                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="exampleModal_{{ $index + 1 }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Home Banner</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="ButtonPressJquery" action="{{ route('admin.homeBanner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf

                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Title</label>
                                                            <input type="text" name="title" class="form-control" id="title" value="{{ $banner->title }}" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="description" class="form-label">Description</label>
                                                            <textarea name="description" class="form-control" id="description" rows="3" required>{{ $banner->description }}</textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="url" class="form-label">URL</label>
                                                            <input type="url" name="url" class="form-control" id="url" value="{{ $banner->url }}" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="image" class="form-label">Upload Banner Image</label>
                                                            <input type="file" name="image" class="form-control" id="image" accept="image/*" onchange="previewImage(event)">
                                                            <img src="{{ asset('uploads/banners/' . $banner->image) }}" alt="Banner" class="my-2 img-thumbnail preview" width="100">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select name="status" class="form-select" id="status" required>
                                                                <option value="Active" {{ $banner->status == 'Active' ? 'selected' : ' ' }}>Active</option>
                                                                <option value="Inactive" {{ $banner->status == 'Active' ? ' ' : 'selected' }}>Inactive</option>
                                                            </select>
                                                            <a ><span class="badge "> {{ $banner->status }} </span></a>
                                                        </div>

                                                        <span id="SubmitButton">
                                                            <input type="submit" class="btn btn-primary px-4" value="Save Changes">
                                                        </span>

                                                        <a href="{{ route('admin.homeBanner') }}" class="btn btn-secondary">Back</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Add new Banner Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Create Home Banner</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="ButtonPressJquery" action="{{ route('admin.homeBanner.store') }}" method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" name="title" class="form-control" id="title" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea name="description" class="form-control" id="description" rows="3" required></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="url" class="form-label">URL</label>
                                                <input type="url" name="url" class="form-control" id="url" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="image" class="form-label">Upload Banner Image</label>
                                                <input type="file" name="image" class="form-control" id="image" accept="image/*" onchange="previewImage(event)" required>
                                                <img src="" alt="Banner" class="my-2 img-thumbnail preview" width="100">
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
                                            <a href="{{ route('admin.homeBanner') }}" class="btn btn-secondary">Back</a>
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
