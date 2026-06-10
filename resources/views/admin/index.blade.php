@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-5">
    <!-- Today Card -->
    <div class="col">
        <div class="alert-success alert mb-0">
            <span><strong>Today</strong></span>
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-success text-light"><i class="icofont-dollar fa-lg"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h1 mb-0"><strong>{{ $today_sales }}</strong></div>
                    <span class="small"><strong>${{ number_format($today_revenue, 2) }}</strong></span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Week Card -->
    <div class="col">
        <div class="alert-danger alert mb-0">
            <span><strong>Week</strong></span>
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-danger text-light"><i class="icofont-coins fa-lg"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h1 mb-0"><strong>{{ $week_sales }}</strong></div>
                    <span class="small"><strong>${{ number_format($week_revenue, 2) }}</strong></span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Month Card -->
    <div class="col">
        <div class="alert-dark alert mb-0">
            <span><strong>Month</strong></span>
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-success text-light"><i class="icofont-money-bag fa-lg"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h1 mb-0"><strong>{{ $month_sales }}</strong></div>
                    <span class="small"><strong>${{ number_format($month_revenue, 2) }}</strong></span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Year Card -->
    <div class="col">
        <div class="alert-warning alert mb-0">
            <span><strong>Year</strong></span>
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-warning text-light"><i class="icofont-money fa-lg"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h1 mb-0"><strong>{{ $year_sales }}</strong></div>
                    <span class="small"><strong>${{ number_format($year_revenue, 2) }}</strong></span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Till Card -->
    <div class="col">
        <div class="alert-info alert mb-0">
            <span><strong>Till</strong></span>
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-info text-light"><i class="icofont-bank"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h1 mb-0"><strong>{{ $total_orders }}</strong></div>
                    <span class="small"><strong>${{ number_format($total_revenue, 2) }}</strong></span>
                </div>
            </div>
        </div>
    </div>
</div><!-- Row end  -->

<div class="row g-3 mb-3">
    <div class="col-lg-12 col-md-12">
        <div class="tab-content mt-1">
            <div class="tab-pane fade show active" id="summery-today">
                <div class="row g-1 g-sm-3 mb-3 row-deck">
                    <!-- Customers Count -->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                        <div class="card">
                            <div class="card-body py-xl-4 py-3 d-flex flex-wrap align-items-center justify-content-between">
                                <div class="left-info">
                                    <span class="text-muted">CUSTOMERS</span>
                                    <div><span class="fs-6 fw-bold me-2">{{ $total_customers }}</span></div>
                                </div>
                                <div class="right-icon">
                                    <i class="icofont-student-alt fs-3 color-light-orange"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Speakers Count -->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                        <div class="card">
                            <div class="card-body py-xl-4 py-3 d-flex flex-wrap align-items-center justify-content-between">
                                <div class="left-info">
                                    <span class="text-muted">SPEAKERS</span>
                                    <div><span class="fs-6 fw-bold me-2">{{ $total_speakers }}</span></div>
                                </div>
                                <div class="right-icon">
                                    <i class="icofont-shopping-cart fs-3 color-lavender-purple"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Webinars Count -->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                        <div class="card">
                            <div class="card-body py-xl-4 py-3 d-flex flex-wrap align-items-center justify-content-between">
                                <div class="left-info">
                                    <span class="text-muted">WEBINARS</span>
                                    <div><span class="fs-6 fw-bold me-2">{{ $total_webinars }}</span></div>
                                </div>
                                <div class="right-icon">
                                    <i class="icofont-sale-discount fs-3 color-santa-fe"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Daily Average Sell -->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                        <div class="card">
                            <div class="card-body py-xl-4 py-3 d-flex flex-wrap align-items-center justify-content-between">
                                <div class="left-info">
                                    <span class="text-muted">DAILY AVERAGE SELL</span>
                                    <div><span class="fs-6 fw-bold me-2">${{ number_format($average_sale, 2) }}</span></div>
                                </div>
                                <div class="right-icon">
                                    <i class="icofont-calculator-alt-2 fs-3 color-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Sell -->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                        <div class="card">
                            <div class="card-body py-xl-4 py-3 d-flex flex-wrap align-items-center justify-content-between">
                                <div class="left-info">
                                    <span class="text-muted">TOTAL SELL</span>
                                    <div><span class="fs-6 fw-bold me-2">${{ number_format($total_revenue, 2) }}</span></div>
                                </div>
                                <div class="right-icon">
                                    <i class="icofont-calculator-alt-1 fs-3 color-lightblue"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Selling Item -->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                        <div class="card">
                            <div class="card-body py-xl-4 py-3 d-flex flex-wrap align-items-center justify-content-between">
                                <div class="left-info">
                                    <span class="text-muted">TOP SELLING ITEM</span>
                                    <div><span class="fs-6 fw-bold me-2">{{ $top_selling_item }}</span></div>
                                    @if($top_selling_quantity > 0)
                                        <small class="text-muted">{{ $top_selling_quantity }} sold</small>
                                    @endif
                                </div>
                                <div class="right-icon">
                                    <i class="icofont-star fs-3 color-lightyellow"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- row end -->
            </div>
        </div>
    </div>
</div><!-- Row end  -->

<div class="row g-3 mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold"><i class="icofont-globe-alt me-2 text-success"></i> Dynamic XML Sitemap & SEO Indexing</h6>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-7">
                        <p class="mb-2 text-muted" style="font-size: 14.5px;">CEUTrainers platform automatically generates a standard-compliant XML Sitemap containing all live static links, webinar routes, and speaker pages. Google and Bing will automatically crawl this sitemap in real-time.</p>
                        <div class="mt-3">
                            <span class="badge bg-success p-2 me-2" style="font-size: 11.5px;"><i class="icofont-check-circled me-1"></i> STATUS: ACTIVE</span>
                            <span class="badge bg-primary p-2 me-2" style="font-size: 11.5px;"><i class="icofont-chart-flow me-1"></i> AUTO REGENERATE: TRUE</span>
                            <span class="badge bg-info p-2" style="font-size: 11.5px;"><i class="icofont-web me-1"></i> INDEXED PAGES: {{ $total_webinars + $total_speakers + 6 }}</span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 text-lg-end mt-3 mt-lg-0">
                        <a href="{{ route('sitemap') }}" target="_blank" class="btn btn-outline-primary py-2 px-3 fw-bold" style="border-radius: 8px;">
                            <i class="icofont-external-link me-1"></i> View Live Sitemap.xml
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold">10 Recent Transactions</h6>
            </div>
            <div class="card-body">
                <table class="table table-hover align-middle mb-0" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ORDER ID</th>
                            <th>WEBINAR</th>
                            <th>SELLING OPTION</th>
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
</div><!-- Row end  -->
@endsection
