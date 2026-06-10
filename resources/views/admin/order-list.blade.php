@extends('admin.layouts.app')

@section('title', 'Orders List')

@section('content')
<div class="row align-items-center">
    <div class="border-0 mb-4">
        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
            <h3 class="fw-bold mb-0">Orders List</h3>
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
                            <th>No.</th>
                            <th>ORDER ID</th>
                            <th>WEBINAR</th>
                            <th>SELLING OPTION</th>
                            <th>PRICE</th>
                            <th>DATE & TIME</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('admin.order.show', $row['id']) }}" class="fw-bold text-primary">
                                    {{ $row['order_id'] }}
                                </a>
                            </td>
                            <td><span>{{ $row['title'] }}</span></td>
                            <td>{{ $row['selling_options'] }}</td>
                            <td><strong>${{ number_format($row['amount'], 2) }}</strong></td>
                            <td>{{ $row['trans_date'] }}</td>
                            <td>
                                <span class="badge {{ $row['payment_status'] == 'Incomplete' ? 'bg-danger' : 'bg-success' }}">
                                    {{ $row['payment_status'] }}
                                </span>
                            </td>
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
