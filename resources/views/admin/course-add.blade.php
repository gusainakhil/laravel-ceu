@extends('admin.layouts.app')

@section('title', 'Add Course')

@section('styles')
<link rel="stylesheet" href="{{ asset('ceuadmin-assets/assets/plugin/dropify/dist/css/dropify.min.css') }}" />
<style>
    .selling-option-card {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background-color: #f8fafc;
        margin-bottom: 20px;
    }
    .selling-option-header {
        background-color: #f1f5f9;
        border-bottom: 1px solid #cbd5e1;
        padding: 10px 15px;
        font-weight: bold;
        color: #1e293b;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
</style>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.course.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0">Add New Course</h3>
                <div>
                    <button type="submit" class="btn btn-primary btn-set-task w-sm-100 py-2 px-5 text-uppercase fw-bold"><i class="icofont-save me-2"></i>Save Course</button>
                    <a href="{{ route('admin.page', 'course-list') }}" class="btn btn-secondary btn-set-task w-sm-100 py-2 px-5 text-uppercase fw-bold">Cancel</a>
                </div>
            </div>
        </div>
    </div> <!-- Row end  -->

    <div class="row g-3 mb-3">
        <!-- Sidebar Options -->
        <div class="col-xl-4 col-lg-4">
            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Industry & Speaker</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Select Industry / Category</label>
                            <select name="industries" class="form-control" required>
                                <option value="">Select an Industry</option>
                                @foreach($db_industries as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Select Speaker</label>
                            <select name="speaker" class="form-control" required>
                                <option value="">Select a Speaker</option>
                                @foreach($db_speakers as $spk)
                                    <option value="{{ $spk->id }}">{{ $spk->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Visibility Status</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status1" value="1" checked>
                                <label class="form-check-label fw-bold" for="status1">Published</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status0" value="0">
                                <label class="form-check-label fw-bold" for="status0">Hidden</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Schedule & Pricing</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Publish Date</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Publish Time</label>
                            <input type="time" name="time" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Duration (Minutes)</label>
                            <div class="input-group">
                                <input type="number" name="duration" class="form-control" placeholder="60" value="60" required>
                                <span class="input-group-text">mins</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Base Price ($) <span class="text-primary">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" id="priceInput" name="price" class="form-control" placeholder="199.00" value="199.00" oninput="updateOptionPrices()" required>
                            </div>
                            <small class="text-muted d-block mt-1">Changing the base price will automatically scale all registration option fees below in real-time!</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form Column -->
        <div class="col-xl-8 col-lg-8">
            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold">Course Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Course Name</label>
                            <input type="text" class="form-control" name="title" id="titleInput" oninput="updateSlug()" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Course Identifier URL <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">https://ceutrainers.com/course-details/</span>
                                <input type="text" class="form-control" id="slugInput" name="slug" required readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Course Description</label>
                            <textarea name="description" id="editor" required></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Certificate Text</label>
                            <textarea name="certificate_text" id="certificateEditor" required>Successfully completed CEU credits certification requirements.</textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                    <h6 class="mb-0 fw-bold">Course Thumbnail</h6>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <input type="file" name="course_thumbail" class="dropify" data-allowed-file-extensions="jpg jpeg png webp" data-max-file-size="2M" required>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- Row end  -->

    <!-- Dynamic Registration Options Panel -->
    <div class="row g-3 mb-3">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h6 class="m-0 fw-bold text-primary"><i class="icofont-tags me-2"></i>Dynamic Registration Options (Course Pricing Customizer)</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">The following registration options are automatically loaded from your global defaults. You can modify any option's absolute price specifically for this course before saving!</p>
                    
                    <div class="row">
                        @php
                            $scaleRules = [
                                '1 Attendee' => ['mult' => 1.0, 'off' => 0.0],
                                '2 Attendees (Save $45)' => ['mult' => 2.0, 'off' => -45.0],
                                '3 Attendees (Get 3 On Demands FREE)' => ['mult' => 3.0, 'off' => -100.0],
                                '4 Attendees (Get 4 On Demands FREE)' => ['mult' => 4.0, 'off' => -175.0],
                                '5 Attendees (Get 5 On Demands FREE)' => ['mult' => 5.0, 'off' => -240.0],
                                'On Demand' => ['mult' => 1.0, 'off' => 0.0],
                                'e-Transcript' => ['mult' => 1.0, 'off' => 15.0],
                                'Live + On Demand' => ['mult' => 1.0, 'off' => 90.0],
                                'Live + e-Transcript' => ['mult' => 1.0, 'off' => 100.0],
                                'On Demand + e-Transcript' => ['mult' => 1.0, 'off' => 80.0],
                                'Live + On Demand + e-Transcript' => ['mult' => 1.0, 'off' => 190.0],
                                '6 Attendees (6 ODs & 6 Transcripts FREE)' => ['mult' => 6.0, 'off' => -295.0],
                                '7 Attendees (7 ODs & 7 Transcripts FREE)' => ['mult' => 7.0, 'off' => -360.0],
                            ];
                        @endphp
                        @foreach($db_default_options as $categoryName => $options)
                        <div class="col-md-12">
                            <div class="selling-option-card">
                                <div class="selling-option-header"><i class="icofont-square me-2"></i>{{ ucfirst($categoryName) }}</div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        @foreach($options as $opt)
                                        @php
                                            $rule = $scaleRules[$opt->label] ?? ['mult' => 1.0, 'off' => 0.0];
                                            $multiplier = $rule['mult'];
                                            $offset = $rule['off'];
                                            $optName = $opt->label;
                                        @endphp
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group mb-2">
                                                <label class="form-label fw-bold text-muted small mb-1">{{ $optName }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" 
                                                           name="options[{{ $categoryName }}][{{ $optName }}]" 
                                                           class="form-control option-price-input" 
                                                           data-multiplier="{{ $multiplier }}" 
                                                           data-offset="{{ $offset }}" 
                                                           value="{{ number_format(($multiplier * 199.00) + $offset, 2, '.', '') }}" 
                                                           step="0.01" 
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script src="{{ asset('ceuadmin-assets/assets/bundles/dropify.bundle.js') }}"></script>
<script>
    // Automatically convert Course Title into a clean Slug
    function convertToSlug(title) {
        return title
            .toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
    }

    function updateSlug() {
        const titleInput = document.getElementById('titleInput');
        const slugInput = document.getElementById('slugInput');
        slugInput.value = convertToSlug(titleInput.value);
    }

    // Dynamic price calculation options matching default formulas
    function updateOptionPrices() {
        const basePrice = parseFloat(document.getElementById('priceInput').value) || 0.00;
        
        // Find and scale all option inputs
        const inputs = document.querySelectorAll('.option-price-input');
        inputs.forEach(input => {
            const multiplier = parseFloat(input.dataset.multiplier) || 1.00;
            const offset = parseFloat(input.dataset.offset) || 0.00;
            const calculated = (basePrice * multiplier) + offset;
            input.value = calculated.toFixed(2);
        });
    }

    $(document).ready(function() {
        // Init CKEditor
        CKEDITOR.replace('description');
        CKEDITOR.replace('certificate_text');
        
        // Init Dropify image upload
        $('.dropify').dropify();
    });
</script>
@endsection
