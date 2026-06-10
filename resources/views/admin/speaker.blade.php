@extends('admin.layouts.app')

@section('title', 'Speakers list')

@section('styles')
<style>
    .cke_notifications_area,
    .cke_notification,
    .cke_notification_warning {
        display: none !important;
    }
</style>
@endsection

@section('content')
<div class="row align-items-center">
    <div class="border-0 mb-4">
        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
            <h3 class="fw-bold mb-0">Speaker Information</h3>
            <button type="button" class="btn btn-primary text-uppercase fw-bold" data-bs-toggle="modal" data-bs-target="#addSpeakerModal">
                <i class="icofont-plus me-2"></i>Add Speaker
            </button>
        </div>
    </div>
</div> <!-- Row end  -->

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Please fix:</strong> {{ $errors->first() }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row clearfix g-3">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-body">
                <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Speaker Name</th>
                            <th>Mail</th>
                            <th>Phone</th>
                            <th>Designation</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($speakers as $row)
                        @php
                            $speakerImage = $row['image'] ?: asset('ceuadmin-assets/assets/images/profile_av.svg');
                            if (!str_starts_with($speakerImage, 'http') && !str_starts_with($speakerImage, '/')) {
                                $speakerImage = asset('ceuadmin-assets/assets/images/speaker/' . $speakerImage);
                            }
                        @endphp
                        <tr>
                            <td><strong>{{ $loop->iteration }}</strong></td>
                            <td>
                                <img class="avatar rounded me-2 bg-light" src="{{ $speakerImage }}" alt="{{ $row['name'] }}" style="width: 40px; height: 40px; object-fit: cover;">
                                <span class="fw-bold">{{ $row['name'] }}</span>
                            </td>
                            <td>{{ $row['email'] }}</td>
                            <td>{{ $row['phone'] }}</td>
                            <td>{{ $row['designation'] }}</td>
                            <td>
                                <span class="badge {{ $row['status'] ? 'bg-success' : 'bg-danger' }}">
                                    {{ $row['status'] ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editSpeakerModal" onclick="populateSpeakerEditForm({{ $row['id'] }}, @js($row['name']), @js($row['email']), @js($row['phone']), @js($row['designation']), @js($row['bio']), @js($speakerImage), {{ $row['status'] }})">
                                    <i class="icofont-ui-edit"></i> Edit
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- Row End -->

<div class="modal fade" id="addSpeakerModal" tabindex="-1" aria-labelledby="addSpeakerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSpeakerModalLabel">Add Speaker</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.speaker.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Speaker Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Designation</label>
                            <input type="text" name="designation" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Bio</label>
                            <textarea name="bio" id="addSpeakerBio" class="form-control" rows="6"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Speaker Image</label>
                            <div class="border rounded bg-light p-2 mb-2" style="width: 130px;">
                                <img id="addSpeakerImagePreview" src="{{ asset('ceuadmin-assets/assets/images/profile_av.svg') }}" alt="Speaker image preview" style="width: 110px; height: 110px; object-fit: cover; border-radius: 6px;">
                            </div>
                            <input type="file" name="image" id="addSpeakerImage" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Speaker</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editSpeakerModal" tabindex="-1" aria-labelledby="editSpeakerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSpeakerModalLabel">Edit Speaker</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSpeakerForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Speaker Name</label>
                            <input type="text" name="name" id="editSpeakerName" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" id="editSpeakerEmail" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Phone</label>
                            <input type="text" name="phone" id="editSpeakerPhone" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Designation</label>
                            <input type="text" name="designation" id="editSpeakerDesignation" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Bio</label>
                            <textarea name="bio" id="editSpeakerBio" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Current Image</label>
                            <div class="border rounded bg-light p-2 mb-2" style="width: 130px;">
                                <img id="editSpeakerImagePreview" src="" alt="Speaker image preview" style="width: 110px; height: 110px; object-fit: cover; border-radius: 6px;">
                            </div>
                            <input type="file" name="image" id="editSpeakerImage" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                            <small class="text-muted">Leave empty to keep current image.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" id="editSpeakerStatus" class="form-select" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
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
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    const speakerEditorConfig = {
        height: 220,
        allowedContent: true,
        versionCheck: false,
        format_tags: 'p;h1;h2;h3;h4;pre',
        toolbar: [
            { name: 'document', items: ['Source'] },
            { name: 'clipboard', items: ['Undo', 'Redo'] },
            { name: 'styles', items: ['Format'] },
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'] },
            { name: 'links', items: ['Link', 'Unlink'] },
            { name: 'insert', items: ['Table', 'HorizontalRule'] }
        ]
    };

    function previewSpeakerImage(input, previewSelector) {
        const file = input.files && input.files[0];
        if (!file) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function(event) {
            $(previewSelector).attr('src', event.target.result);
        };
        reader.readAsDataURL(file);
    }

    function populateSpeakerEditForm(id, name, email, phone, designation, bio, imageUrl, status) {
        document.getElementById('editSpeakerName').value = name || '';
        document.getElementById('editSpeakerEmail').value = email === 'N/A' ? '' : (email || '');
        document.getElementById('editSpeakerPhone').value = phone === 'N/A' ? '' : (phone || '');
        document.getElementById('editSpeakerDesignation').value = designation || '';
        if (CKEDITOR.instances.editSpeakerBio) {
            CKEDITOR.instances.editSpeakerBio.setData(bio || '');
        } else {
            document.getElementById('editSpeakerBio').value = bio || '';
        }
        document.getElementById('editSpeakerImage').value = '';
        document.getElementById('editSpeakerImagePreview').src = imageUrl || "{{ asset('ceuadmin-assets/assets/images/profile_av.svg') }}";
        document.getElementById('editSpeakerStatus').value = status ? '1' : '0';
        document.getElementById('editSpeakerForm').action = `/ceuadmin/speaker-update/${id}`;
    }

    $(document).ready(function() {
        CKEDITOR.replace('addSpeakerBio', speakerEditorConfig);
        CKEDITOR.replace('editSpeakerBio', speakerEditorConfig);

        $('#myProjectTable')
            .addClass('nowrap')
            .dataTable({
                responsive: true
            });

        $('#editSpeakerImage').on('change', function() {
            previewSpeakerImage(this, '#editSpeakerImagePreview');
        });

        $('#addSpeakerImage').on('change', function() {
            previewSpeakerImage(this, '#addSpeakerImagePreview');
        });

        $('#addSpeakerModal').on('hidden.bs.modal', function() {
            if (CKEDITOR.instances.addSpeakerBio) {
                CKEDITOR.instances.addSpeakerBio.setData('');
            }
            $('#addSpeakerImagePreview').attr('src', "{{ asset('ceuadmin-assets/assets/images/profile_av.svg') }}");
        });
    });
</script>
@endsection
