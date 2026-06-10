@extends('admin.layouts.app')

@section('title', 'Manage Industries')

@section('content')
<div class="row align-items-center">
    <div class="border-0 mb-4">
        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
            <h3 class="fw-bold mb-0">Industries / Categories Management</h3>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row g-3 mb-3">
    <!-- Left Column: Add Industry Form -->
    <div class="col-xl-4 col-lg-5 col-md-12">
        <div class="card mb-3">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Add New Industry</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.industry.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Industry Name</label>
                            <input type="text" name="name" id="industryName" class="form-control" placeholder="e.g. HR Compliance" oninput="generateSlug()" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Identifier Slug</label>
                            <input type="text" name="slug" id="industrySlug" class="form-control" placeholder="e.g. hr-compliance" required readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Industry Image</label>
                            <input type="file" name="image" id="industryImage" class="form-control" accept=".jpg,.jpeg,.png,.webp,.svg">
                            <small class="text-muted">Upload jpg, jpeg, png, webp, or svg image.</small>
                            <div class="mt-2 d-none" id="industryImagePreviewWrap">
                                <img id="industryImagePreview" src="" alt="Industry image preview" class="border rounded bg-light p-1" style="width: 80px; height: 80px; object-fit: contain;">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="1" selected>Active / Visible</option>
                                <option value="0">Inactive / Hidden</option>
                            </select>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary text-uppercase px-4 w-100 fw-bold">Create Industry</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column: Industries Table -->
    <div class="col-xl-8 col-lg-7 col-md-12">
        <div class="card mb-3">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">All Seeded & Created Industries</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="industriesTable" class="table table-hover align-middle mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Industry Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($industries as $row)
                            <tr>
                                <td><strong>{{ $loop->iteration }}</strong></td>
                                <td>
                                    @php
                                        $img = $row->image ?: 'default-industry.png';
                                        if (!str_starts_with($img, 'http')) {
                                            $img = asset('assets/images/category/' . $img);
                                        }
                                    @endphp
                                    <img class="avatar rounded me-2 bg-light" src="{{ $img }}" alt="" style="width: 40px; height: 40px; object-fit: contain;">
                                </td>
                                <td><span class="fw-bold text-dark">{{ $row->name }}</span></td>
                                <td><code>{{ $row->slug }}</code></td>
                                <td>
                                    <span class="badge {{ $row->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $row->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editIndustryModal" onclick="populateEditForm({{ $row->id }}, @js($row->name), @js($row->slug), @js($row->image), @js($img), {{ $row->status }})">
                                        <i class="icofont-ui-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.industry.delete', $row->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this industry? All courses mapped to this category will be set to uncategorized.');" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="icofont-ui-delete"></i> Delete
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

<!-- Edit Industry Modal -->
<div class="modal fade" id="editIndustryModal" tabindex="-1" aria-labelledby="editIndustryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editIndustryModalLabel">Edit Industry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editIndustryForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Industry Name</label>
                            <input type="text" name="name" id="editIndustryName" class="form-control" placeholder="e.g. HR Compliance" oninput="generateEditSlug()" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Identifier Slug</label>
                            <input type="text" name="slug" id="editIndustrySlug" class="form-control" placeholder="e.g. hr-compliance" required readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Current Image</label>
                            <div class="border rounded bg-light p-2 mb-2" style="width: 110px;">
                                <img id="editIndustryImagePreview" src="" alt="Current industry image" style="width: 90px; height: 90px; object-fit: contain;">
                            </div>
                            <input type="hidden" id="editIndustryImageName">
                            <label class="form-label fw-bold">Replace Image</label>
                            <input type="file" name="image" id="editIndustryImage" class="form-control" accept=".jpg,.jpeg,.png,.webp,.svg">
                            <small class="text-muted">Leave empty to keep current image.</small>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" id="editIndustryStatus" class="form-select" required>
                                <option value="1">Active / Visible</option>
                                <option value="0">Inactive / Hidden</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    function convertToSlug(text) {
        return text
            .toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
    }

    function generateSlug() {
        const nameInput = document.getElementById('industryName');
        const slugInput = document.getElementById('industrySlug');
        slugInput.value = convertToSlug(nameInput.value);
    }

    function generateEditSlug() {
        const nameInput = document.getElementById('editIndustryName');
        const slugInput = document.getElementById('editIndustrySlug');
        slugInput.value = convertToSlug(nameInput.value);
    }

    function previewSelectedImage(input, imageSelector, wrapperSelector = null) {
        const file = input.files && input.files[0];
        if (!file) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function(event) {
            const image = document.querySelector(imageSelector);
            if (image) {
                image.src = event.target.result;
            }
            if (wrapperSelector) {
                const wrapper = document.querySelector(wrapperSelector);
                if (wrapper) {
                    wrapper.classList.remove('d-none');
                }
            }
        };
        reader.readAsDataURL(file);
    }

    function populateEditForm(id, name, slug, image, imageUrl, status) {
        document.getElementById('editIndustryName').value = name;
        document.getElementById('editIndustrySlug').value = slug;
        document.getElementById('editIndustryImage').value = '';
        document.getElementById('editIndustryImageName').value = image || '';
        document.getElementById('editIndustryImagePreview').src = imageUrl || '';
        document.getElementById('editIndustryStatus').value = status;
        
        // Set the form action to the update route
        const form = document.getElementById('editIndustryForm');
        form.action = `/ceuadmin/industries-update/${id}`;
    }

    $(document).ready(function() {
        $('#industriesTable')
            .addClass('nowrap')
            .dataTable({
                responsive: true
            });

        $('#industryImage').on('change', function() {
            previewSelectedImage(this, '#industryImagePreview', '#industryImagePreviewWrap');
        });

        $('#editIndustryImage').on('change', function() {
            previewSelectedImage(this, '#editIndustryImagePreview');
        });
    });
</script>
@endsection
