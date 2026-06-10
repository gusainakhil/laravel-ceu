@extends('admin.layouts.app')

@section('title', 'Contact Form Inquiries')

@section('content')
<div class="row align-items-center">
    <div class="border-0 mb-4">
        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
            <h3 class="fw-bold mb-0">Contact Form Inquiries</h3>
        </div>
    </div>
</div> <!-- Row end  -->

<div class="row g-3 mb-3">
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-body">
                <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Sender Name</th>
                            <th>Email Address</th>
                            <th>Subject</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $row)
                        <tr>
                            <td><strong>{{ $loop->iteration }}</strong></td>
                            <td><span class="fw-bold">{{ $row['name'] }}</span></td>
                            <td>{{ $row['email'] }}</td>
                            <td><span class="text-primary">{{ $row['subject'] }}</span></td>
                            <td>{{ $row['message'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- Row end  -->
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
