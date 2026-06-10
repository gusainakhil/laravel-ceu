@extends('admin.layouts.app')

@section('title', 'Edit Course')

@section('styles')
<link rel="stylesheet" href="{{ asset('ceuadmin-assets/assets/plugin/dropify/dist/css/dropify.min.css') }}" />
<style>
    .course-card {
        margin-bottom: 1rem;
    }

    .course-card .card-header {
        background: transparent;
        border-bottom: 0;
    }

    .course-card .card-header h6 {
        margin: 0;
        font-weight: 700;
    }

    .course-card .card-body {
        padding: 1rem;
    }

    .form-group-wrapper {
        margin-bottom: 1rem;
    }

    .form-label {
        font-weight: 700;
    }

    .section-title {
        color: #484c7f;
        font-size: 0.95rem;
        font-weight: 700;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e9ecef;
    }

    .selling-option-card {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background-color: #f8fafc;
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .selling-option-header {
        background-color: #f1f5f9;
        border-bottom: 1px solid #cbd5e1;
        color: #1e293b;
        font-weight: 700;
        padding: 10px 15px;
    }

    .options-table {
        background-color: #fff;
    }

    .options-table th {
        font-weight: 700;
    }

    .text-info-custom {
        color: #6c757d;
        display: block;
        margin-top: 0.35rem;
    }

    .cke_chrome {
        border-color: #ced4da !important;
        border-radius: 0.25rem;
        overflow: hidden;
    }

    .cke_top {
        background: #f8f9fa !important;
        border-bottom-color: #e9ecef !important;
    }

    .editor-container {
        display: block;
    }

    .editor-container .form-label {
        display: block;
        margin-bottom: 0.5rem;
    }

    .editor-container textarea {
        display: block;
        width: 100%;
        min-height: 160px;
    }

    @media (max-width: 768px) {
        .page-header-actions {
            flex-direction: column;
            gap: 0.5rem;
        }

        .page-header-actions .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.course.update', $course->id) }}" enctype="multipart/form-data">
    @csrf

    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <div>
                    <h3 class="fw-bold mb-0">Edit Course</h3>
                    <span class="text-muted">{{ $course->title }}</span>
                </div>
                <div class="page-header-actions d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary btn-set-task w-sm-100 py-2 px-5 text-uppercase fw-bold"><i class="icofont-save me-2"></i>Save Changes</button>
                    <a href="{{ route('admin.page', 'course-list') }}" class="btn btn-secondary btn-set-task w-sm-100 py-2 px-5 text-uppercase fw-bold">Cancel</a>
                </div>
            </div>
        </div>
    </div> <!-- Row end  -->

    <!-- Course Information Section -->
    <div class="row g-3 mb-3">
        <div class="col-lg-8">
            <div class="card course-card">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Course Information</h6>
                </div>
                <div class="card-body">
                    <div class="form-group-wrapper">
                        <label class="form-label">Course Title</label>
                        <input type="text" class="form-control" name="title" id="titleInput" value="{{ $course->title }}" oninput="updateSlug()" required>
                    </div>

                    <div class="form-group-wrapper">
                        <label class="form-label">Course URL Slug</label>
                        <div class="input-group">
                            <span class="input-group-text">ceutrainers.com/course-details/</span>
                            <input type="text" class="form-control" id="slugInput" name="slug" value="{{ $course->slug }}" required readonly>
                        </div>
                        <small class="text-info-custom"><i class="icofont-info-square me-1"></i>Auto-generated from title</small>
                    </div>

                    <div class="form-group-wrapper editor-container">
                        <label class="form-label">Course Description</label>
                        <textarea name="description" id="editor" class="form-control" required>{{ $course->description }}</textarea>
                    </div>

                    <div class="form-group-wrapper editor-container">
                        <label class="form-label">Certificate Text</label>
                        <textarea name="certificate_text" id="certificateEditor" class="form-control" required>{{ $course->certificate_text ?? 'Successfully completed CEU credits certification requirements.' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Section -->
        <div class="col-lg-4">
            <!-- Category & Speaker -->
            <div class="card course-card">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Category & Speaker</h6>
                </div>
                <div class="card-body">
                    <div class="form-group-wrapper">
                        <label class="form-label">Industry / Category</label>
                        <select name="industries" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach($db_industries as $cat)
                                <option value="{{ $cat->id }}" {{ $course->industry_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group-wrapper">
                        <label class="form-label">Speaker</label>
                        <select name="speaker" class="form-select" required>
                            <option value="">Select Speaker</option>
                            @foreach($db_speakers as $spk)
                                <option value="{{ $spk->id }}" {{ $course->speaker_id == $spk->id ? 'selected' : '' }}>{{ $spk->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Status & Schedule -->
            <div class="card course-card">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Status & Schedule</h6>
                </div>
                <div class="card-body">
                    <div class="form-group-wrapper">
                        <label class="form-label mb-3">Publication Status</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status1" value="1" {{ $course->status === 'published' ? 'checked' : '' }}>
                                <label class="form-check-label fw-500" for="status1">
                                    <span class="badge bg-success me-2">Live</span>Published
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status0" value="0" {{ $course->status === 'draft' ? 'checked' : '' }}>
                                <label class="form-check-label fw-500" for="status0">
                                    <span class="badge bg-warning me-2">Draft</span>Hidden
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group-wrapper">
                        <label class="form-label">Event Date</label>
                        <input type="date" name="date" class="form-control" value="{{ $course->event_date ? $course->event_date->format('Y-m-d') : '' }}" required>
                    </div>

                    <div class="form-group-wrapper">
                        <label class="form-label">Event Time</label>
                        <input type="time" name="time" class="form-control" value="{{ $course->event_time ?? '' }}" required>
                    </div>

                    <div class="form-group-wrapper">
                        <label class="form-label">Duration</label>
                        <div class="input-group">
                            <input type="number" name="duration" class="form-control" value="{{ $course->duration_minutes ?? 60 }}" required>
                            <span class="input-group-text">minutes</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="card course-card">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Pricing</h6>
                </div>
                <div class="card-body">
                    <div class="form-group-wrapper">
                        <label class="form-label">Base Price</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" id="priceInput" name="price" class="form-control" value="{{ $course->default_price ?? 185.00 }}" oninput="updateOptionPrices()" step="0.01" required>
                        </div>
                        <small class="text-info-custom"><i class="icofont-info-square me-1"></i>Course base price</small>
                    </div>
                </div>
            </div>

            <!-- Thumbnail -->
            <div class="card course-card">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Course Thumbnail</h6>
                </div>
                <div class="card-body">
                    @php
                        $thumbnail = $course->thumbnail ?: 'ceutrainers.webp';
                        $thumbnailUrl = str_starts_with($thumbnail, 'http')
                            ? $thumbnail
                            : asset('ceuadmin-assets/assets/images/course/' . $thumbnail);
                    @endphp
                    <div class="mb-3">
                        <label class="form-label text-muted">Current Preview</label>
                        <div class="border rounded bg-light p-2">
                            <img id="thumbnailPreview" src="{{ $thumbnailUrl }}" alt="Course thumbnail preview" style="width: 100%; max-height: 220px; object-fit: contain; border-radius: 6px; background: #ffffff;">
                        </div>
                    </div>
                    <input type="file" name="course_thumbail" class="dropify" data-default-file="{{ $thumbnailUrl }}" data-allowed-file-extensions="jpg jpeg png webp" data-max-file-size="2M">
                    <small class="text-muted d-block mt-2">Current thumbnail preview. Upload a new image to replace it.</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Options Section -->
    <div class="row g-3 mb-3">
        <div class="col-12">
            <div class="card course-card">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold text-primary"><i class="icofont-tags me-2"></i>Registration Options & Pricing</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4"><i class="icofont-info-circle me-2"></i>Customize pricing for each registration option. These override the global defaults for this course.</p>
                    
                    @foreach($db_default_options as $categoryName => $options)
                    <div class="mb-4">
                        <h6 class="section-title">{{ ucfirst($categoryName) }}</h6>
                        <div class="table-responsive">
                            <table class="table table-hover options-table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 40%;">Option Name</th>
                                        <th style="width: 30%;">Default Price</th>
                                        <th style="width: 30%;">This Course Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($options as $item)
                                        @php
                                            $coursePrice = $coursePricing[$item->id] ?? $item->price;
                                        @endphp
                                        <tr>
                                            <td class="fw-500">{{ $item->label }}</td>
                                            <td><span class="badge bg-light text-dark">${{ number_format($item->price, 2) }}</span></td>
                                            <td>
                                                <div class="input-group input-group-sm" style="max-width: 150px;">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" name="options[{{ $item->category }}][{{ $item->label }}]" class="form-control" value="{{ $coursePrice }}" step="0.01" placeholder="0.00">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</form>
@endsection

@section('scripts')
<script src="{{ asset('ceuadmin-assets/assets/plugin/dropify/dist/js/dropify.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    const editorConfig = {
        height: 260,
        allowedContent: true,
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

    CKEDITOR.replace('editor', editorConfig);
    CKEDITOR.replace('certificateEditor', editorConfig);

    function updateSlug() {
        const title = document.getElementById('titleInput').value;
        const slug = title
            .toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
        document.getElementById('slugInput').value = slug;
    }

    function updateOptionPrices() {
        // Price update logic can be added here if needed
    }

    $(document).ready(function() {
        $('.dropify').dropify();

        $('input[name="course_thumbail"]').on('change', function() {
            const file = this.files && this.files[0];
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                $('#thumbnailPreview').attr('src', event.target.result);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endsection
