@extends('admin.layouts.app')

@section('title', 'Default Registration Options')

@section('content')
<div class="row align-items-center">
    <div class="border-0 mb-4">
        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
            <h3 class="fw-bold mb-0">Global Default Registration Options Template</h3>
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
    <!-- Left Column: Add New Default Option Form -->
    <div class="col-xl-4 col-lg-5 col-md-12">
        <div class="card mb-3">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Add Global Default Option</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.selling-option.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Option Category</label>
                            <select name="category" class="form-select" required>
                                <option value="live">Live Options</option>
                                <option value="recording">Recording / On-Demand</option>
                                <option value="combo">Combo Options</option>
                                <option value="super_saver">Super Saver Options</option>
                                <option value="custom">Custom Add-ons</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Option Label / Title</label>
                            <input type="text" name="label" class="form-control" placeholder="e.g. 1 Attendee, Live + On Demand" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Attendees Count</label>
                            <input type="number" name="attendees" class="form-control" value="1" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="1" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Default Price ($)</label>
                            <input type="number" name="price" class="form-control" placeholder="185.00" step="0.01" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Compare At Price ($)</label>
                            <input type="number" name="compare_at_price" class="form-control" placeholder="Optional" step="0.01" min="0">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Description (Optional)</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Brief note..."></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary text-uppercase px-4 w-100 fw-bold">Create Default Option</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column: Default Options Table -->
    <div class="col-xl-8 col-lg-7 col-md-12">
        <div class="card mb-3">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">Current Blueprint Registration Options</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="defaultOptionsTable" class="table table-hover align-middle mb-0" style="width:100%">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Category</th>
                                <th>Label / Name</th>
                                <th>Price</th>
                                <th>Attendees</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($default_options as $row)
                            <tr>
                                <td><span class="badge bg-light text-dark fw-bold">{{ $row->sort_order }}</span></td>
                                <td>
                                    <span class="badge bg-info text-capitalize">
                                        {{ str_replace('_', ' ', $row->category) }}
                                    </span>
                                </td>
                                <td><span class="fw-bold text-dark">{{ $row->label }}</span></td>
                                <td>
                                    <strong class="text-success">${{ number_format($row->price, 2) }}</strong>
                                    @if($row->compare_at_price)
                                    <span class="text-muted text-decoration-line-through small ms-1">${{ number_format($row->compare_at_price, 2) }}</span>
                                    @endif
                                </td>
                                <td><span class="fw-bold">{{ $row->attendees }}</span></td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-primary edit-option-btn me-1" 
                                            data-id="{{ $row->id }}"
                                            data-category="{{ $row->category }}"
                                            data-label="{{ $row->label }}"
                                            data-attendees="{{ $row->attendees }}"
                                            data-sort="{{ $row->sort_order }}"
                                            data-price="{{ $row->price }}"
                                            data-compare="{{ $row->compare_at_price }}"
                                            data-description="{{ $row->description }}">
                                        <i class="icofont-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.selling-option.delete', $row->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this option from the default templates? Existing courses will keep their customized overrides, but new courses will not have this option pre-populated.');" class="d-inline">
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

<!-- Edit Option Modal -->
<div class="modal fade" id="editOptionModal" tabindex="-1" aria-labelledby="editOptionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editOptionModalLabel">Edit Default Option</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editOptionForm" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Option Category</label>
                            <select name="category" id="editCategory" class="form-select" required>
                                <option value="live">Live Options</option>
                                <option value="recording">Recording / On-Demand</option>
                                <option value="combo">Combo Options</option>
                                <option value="super_saver">Super Saver Options</option>
                                <option value="custom">Custom Add-ons</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Option Label / Title</label>
                            <input type="text" name="label" id="editLabel" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Attendees Count</label>
                            <input type="number" name="attendees" id="editAttendees" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="editSort" class="form-control" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Default Price ($)</label>
                            <input type="number" name="price" id="editPrice" class="form-control" step="0.01" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Compare At Price ($)</label>
                            <input type="number" name="compare_at_price" id="editCompare" class="form-control" step="0.01" min="0">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Description (Optional)</label>
                            <textarea name="description" id="editDescription" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary fw-bold text-uppercase">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#defaultOptionsTable')
            .addClass('nowrap')
            .dataTable({
                responsive: true,
                pageLength: 25
            });

        // Dynamic Edit Modal Pre-population
        $(document).on('click', '.edit-option-btn', function() {
            const id = $(this).data('id');
            const category = $(this).data('category');
            const label = $(this).data('label');
            const attendees = $(this).data('attendees');
            const sort = $(this).data('sort');
            const price = $(this).data('price');
            const compare = $(this).data('compare');
            const description = $(this).data('description');

            $('#editCategory').val(category);
            $('#editLabel').val(label);
            $('#editAttendees').val(attendees);
            $('#editSort').val(sort);
            $('#editPrice').val(price);
            $('#editCompare').val(compare);
            $('#editDescription').val(description);

            // Update Form Route
            $('#editOptionForm').attr('action', `/ceuadmin/selling-options-update/${id}`);
            
            // Explicitly show modal
            const editModal = new bootstrap.Modal(document.getElementById('editOptionModal'));
            editModal.show();
        });
    });
</script>
@endsection
