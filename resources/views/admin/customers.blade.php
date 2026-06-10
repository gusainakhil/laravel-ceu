@extends('admin.layouts.app')

@section('title', 'Customers list')

@section('content')
<div class="row align-items-center">
    <div class="border-0 mb-4">
        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
            <h3 class="fw-bold mb-0">Customer Information</h3>
        </div>
    </div>
</div> <!-- Row end  -->

<div class="row clearfix g-3">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-body">
                <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Customer Name</th>
                            <th>Mail</th>
                            <th>Phone</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $row)
                        <tr>
                            <td><strong>{{ $loop->iteration }}</strong></td>
                            <td>
                                <a href="{{ route('admin.customer.show', $row['id']) }}" class="d-flex align-items-center text-decoration-none">
                                    <img class="avatar rounded me-2" src="{{ asset('ceuadmin-assets/assets/images/profile_av.svg') }}" alt="" style="width: 40px; height: 40px;">
                                    <span class="fw-bold">{{ $row['name'] }}</span>
                                </a>
                            </td>
                            <td>{{ $row['email'] }}</td>
                            <td>{{ $row['phone'] }}</td>
                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- Row End -->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#myProjectTable')
            .addClass('nowrap')
            .dataTable({
                responsive: true
            });
    });
</script>
@endsection
