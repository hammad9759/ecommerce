@extends('admin/layout')

@section('title')
    Taxes
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Taxes</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Taxes</li>
                        </ol>
                    </nav>
                </div>

                <div class="ms-auto">
                    <div class="btn">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaxModal"><i class="lni lni-circle-plus"></i> Add new Tax</button>
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
                                    <th>Name</th>
                                    <th>Rate</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($taxes as $index => $tax)
                                    <tr>
                                        <td class="align-middle">{{ $index + 1 }}</td>
                                        <td class="align-middle">{{ $tax->name }}</td>
                                        <td class="align-middle">{{ $tax->rate }}</td>
                                        <td class="align-middle">{{ $tax->type }}</td>
                                        <td>
                                            <a href="{{ route('admin.taxes.status', $tax->id) }}" class="toggle-status">
                                                <span class="badge {{ $tax->status == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $tax->status }}
                                                </span>
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex order-actions">
                                                <a href="#" data-bs-toggle="modal" class="btn btn-primary btn-sm m-2" data-bs-target="#editTaxModal_{{ $index + 1 }}" > <i class="bx bxs-edit"></i> </a>

                                                <form action="{{ route('admin.taxes.delete', $tax->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm m-2" onclick="return confirm('Are you sure you want to delete this tax?');">
                                                        <i class="bx bxs-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="editTaxModal_{{ $index + 1 }}" tabindex="-1" aria-labelledby="editTaxModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editTaxModalLabel">Edit Tax</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="ButtonPressJquery" action="{{ route('admin.taxes.update', $tax->id) }}" method="POST">
                                                        @csrf

                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" name="name" class="form-control" id="name" value="{{ $tax->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="rate" class="form-label">Rate</label>
                                                            <input type="number" name="rate" class="form-control" id="rate" value="{{ $tax->rate }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="type" class="form-label">Type</label>
                                                            <select name="type" class="form-select" id="type" required>
                                                                <option value="percentage" {{ $tax->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                                                <option value="fixed" {{ $tax->type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select name="status" class="form-control">
                                                                <option value="Active" {{ $tax->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                                <option value="Inactive" {{ $tax->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </div>
                                                        <span id="SubmitButton">
                                                            <input type="submit" class="btn btn-primary px-4" value="Save Changes">
                                                        </span>
                                                        <a href="{{ route('admin.taxes.index') }}" class="btn btn-secondary">Back</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="modal fade" id="addTaxModal" tabindex="-1" aria-labelledby="addTaxModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addTaxModalLabel">Create Tax</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="ButtonPressJquery" action="{{ route('admin.taxes.store') }}" method="post">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" name="name" class="form-control" id="name" required placeholder='"VAT", "Sales Tax"'>
                                            </div>
                                            <div class="mb-3">
                                                <label for="rate" class="form-label">Rate</label>
                                                <input type="number" name="rate" class="form-control" id="rate" required placeholder="Tax rate (e.g., 8.25)">
                                            </div>
                                            <div class="mb-3">
                                                <label for="type" class="form-label">Type</label>
                                                <select name="type" class="form-select" id="type" required>
                                                    <option value="percentage">Percentage</option>
                                                    <option value="fixed">Fixed</option>
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
                                            <a href="{{ route('admin.taxes.index') }}" class="btn btn-secondary">Back</a>
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

{{-- attributes,
attribute_values,
brands,
categories,
category_attributes,
colors,
failed_jobs,
home_banners,
migrations,
password_resets,
personal_access_tokens,
roles,
sizes,
taxes,
users,
user_roles --}}
