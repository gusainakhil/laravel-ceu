@extends('admin.layouts.app')

@section('title', 'Campaign Report')

@section('styles')
<style>
    .sortable-header {
        cursor: pointer;
        user-select: none;
    }
    .sortable-header:after {
        content: ' ⇅';
        font-size: 0.75em;
        color: #9ca3af;
        margin-left: 5px;
        display: inline-block;
    }
    .sortable-header.asc:after {
        content: ' ▲';
        color: var(--primary-color, #1ab69d);
    }
    .sortable-header.desc:after {
        content: ' ▼';
        color: var(--primary-color, #1ab69d);
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="row align-items-center">
    <div class="border-0 mb-4">
        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
            <div>
                <h3 class="fw-bold mb-0">Campaign Attribution Report</h3>
                <p class="text-muted mb-0">Performance metrics and marketing UTM analytics</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary py-2 px-4 text-uppercase fw-bold">
                <i class="icofont-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>
</div>

<!-- Filters form -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.campaign.report') }}">
            <div class="row align-items-end g-3">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label class="form-label fw-bold">From Date</label>
                    <input type="date" name="from_date" value="{{ $from_date }}" class="form-control">
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label class="form-label fw-bold">To Date</label>
                    <input type="date" name="to_date" value="{{ $to_date }}" class="form-control">
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12 d-flex align-items-center mb-2">
                    <div class="form-check pt-md-4">
                        <input class="form-check-input" type="checkbox" name="only_completed" value="1" id="onlyCompleted" {{ $only_completed ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold ms-2" for="onlyCompleted" style="cursor: pointer;">
                            Only Completed Orders
                        </label>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-sm-12 d-flex gap-2 justify-content-lg-end justify-content-md-start">
                    <button type="submit" class="btn btn-primary px-4 py-2 text-uppercase fw-bold">
                        Apply Filter
                    </button>
                    <button type="submit" formaction="{{ route('admin.campaign.report') }}?export=csv" class="btn btn-success px-4 py-2 text-uppercase fw-bold">
                        Export CSV
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Metrics Row (Alert styles matching index dashboard) -->
<div class="row g-3 mb-3 row-cols-1 row-cols-md-3">
    <!-- Total Orders -->
    <div class="col">
        <div class="alert alert-info mb-0">
            <span><strong>Total Orders</strong></span>
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-info text-light"><i class="icofont-shopping-cart fa-lg"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h1 mb-0"><strong>{{ $total_orders }}</strong></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Paid Orders -->
    <div class="col">
        <div class="alert alert-success mb-0">
            <span><strong>Paid Orders</strong></span>
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-success text-light"><i class="icofont-check-circled fa-lg"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h1 mb-0"><strong>{{ $paid_orders }}</strong></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Paid Revenue -->
    <div class="col">
        <div class="alert alert-warning mb-0">
            <span><strong>Paid Revenue</strong></span>
            <div class="d-flex align-items-center">
                <div class="avatar rounded no-thumbnail bg-warning text-light"><i class="icofont-money fa-lg"></i></div>
                <div class="flex-fill ms-3 text-truncate">
                    <div class="h1 mb-0"><strong>${{ number_format($paid_revenue, 2) }}</strong></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Campaign Rankings Row -->
<div class="row g-3 mb-3">
    <!-- Top 5 Performing Campaigns -->
    <div class="col-lg-6">
        <div class="card mb-3">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold"><i class="icofont-trophy text-warning me-2"></i>Top 5 Performing Campaigns</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3">Source</th>
                                <th>Medium</th>
                                <th>Campaign</th>
                                <th class="text-center">Orders</th>
                                <th class="text-center">Paid</th>
                                <th class="text-center">Conv. %</th>
                                <th class="text-end pe-3">Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($top_performing as $campaign)
                            <tr>
                                <td class="ps-3"><strong>{{ $campaign['source'] }}</strong></td>
                                <td><span class="badge bg-secondary">{{ $campaign['medium'] }}</span></td>
                                <td><span class="text-muted">{{ $campaign['campaign'] }}</span></td>
                                <td class="text-center">{{ $campaign['orders'] }}</td>
                                <td class="text-center">{{ $campaign['paid_orders'] }}</td>
                                <td class="text-center text-success"><strong>{{ number_format($campaign['conversion_rate'], 2) }}%</strong></td>
                                <td class="text-end pe-3"><strong>${{ number_format($campaign['revenue'], 2) }}</strong></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No data available.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top 5 Losing Campaigns -->
    <div class="col-lg-6">
        <div class="card mb-3">
            <div class="card-header py-3 bg-transparent border-bottom-0">
                <h6 class="m-0 fw-bold"><i class="icofont-ban text-danger me-2"></i>Top 5 Losing Campaigns</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3">Source</th>
                                <th>Medium</th>
                                <th>Campaign</th>
                                <th class="text-center">Orders</th>
                                <th class="text-center">Paid</th>
                                <th class="text-center">Conv. %</th>
                                <th class="text-end pe-3">Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($top_losing as $campaign)
                            <tr>
                                <td class="ps-3"><strong>{{ $campaign['source'] }}</strong></td>
                                <td><span class="badge bg-secondary">{{ $campaign['medium'] }}</span></td>
                                <td><span class="text-muted">{{ $campaign['campaign'] }}</span></td>
                                <td class="text-center">{{ $campaign['orders'] }}</td>
                                <td class="text-center">{{ $campaign['paid_orders'] }}</td>
                                <td class="text-center text-danger"><strong>{{ number_format($campaign['conversion_rate'], 2) }}%</strong></td>
                                <td class="text-end pe-3"><strong>${{ number_format($campaign['revenue'], 2) }}</strong></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No data available.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- UTM Summary Card -->
<div class="card mb-3">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="m-0 fw-bold"><i class="icofont-chart-histogram me-2"></i>UTM Summary</h6>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 gap-2">
            <div class="d-flex align-items-center">
                <span class="text-secondary me-2">Show</span>
                <select id="utmEntries" class="form-select py-1 px-3" style="width: auto;">
                    <option value="10">10</option>
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-secondary ms-2">entries</span>
            </div>
            <div class="d-flex align-items-center">
                <span class="text-secondary me-2">Search:</span>
                <input type="text" id="utmSearch" class="form-control py-1 px-3" placeholder="Search UTM tags..." style="width: 250px;">
            </div>
        </div>

        <div class="table-responsive">
            <table id="utmSummaryTable" class="table table-hover align-middle mb-0" data-sort-dir="asc">
                <thead>
                    <tr>
                        <th class="ps-3 sortable-header" onclick="sortTable('utmSummaryTable', 0, false)">Source</th>
                        <th class="sortable-header" onclick="sortTable('utmSummaryTable', 1, false)">Medium</th>
                        <th class="sortable-header" onclick="sortTable('utmSummaryTable', 2, false)">Campaign</th>
                        <th class="text-center sortable-header" onclick="sortTable('utmSummaryTable', 3, true)">Orders</th>
                        <th class="text-center sortable-header" onclick="sortTable('utmSummaryTable', 4, true)">Paid Orders</th>
                        <th class="text-center sortable-header" onclick="sortTable('utmSummaryTable', 5, true)">Conversion %</th>
                        <th class="text-end pe-3 sortable-header" onclick="sortTable('utmSummaryTable', 6, true)">Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($utm_summary as $campaign)
                    <tr>
                        <td class="ps-3"><strong>{{ $campaign['source'] }}</strong></td>
                        <td><span class="badge bg-secondary">{{ $campaign['medium'] }}</span></td>
                        <td><span class="text-muted">{{ $campaign['campaign'] }}</span></td>
                        <td class="text-center">{{ $campaign['orders'] }}</td>
                        <td class="text-center">{{ $campaign['paid_orders'] }}</td>
                        <td class="text-center"><strong>{{ number_format($campaign['conversion_rate'], 2) }}%</strong></td>
                        <td class="text-end pe-3"><strong>${{ number_format($campaign['revenue'], 2) }}</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No UTM records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap mt-3 gap-2">
            <span id="utmPaginationInfo" class="text-secondary small">Showing 0 to 0 of 0 entries</span>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item" id="utmPrev"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item" id="utmNext"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Order-Level Attribution Card -->
<div class="card mb-3">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="m-0 fw-bold"><i class="icofont-list me-2"></i>Order-Level Attribution</h6>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 gap-2">
            <div class="d-flex align-items-center">
                <span class="text-secondary me-2">Show</span>
                <select id="orderEntries" class="form-select py-1 px-3" style="width: auto;">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50" selected>50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-secondary ms-2">entries</span>
            </div>
            <div class="d-flex align-items-center">
                <span class="text-secondary me-2">Search:</span>
                <input type="text" id="orderSearch" class="form-control py-1 px-3" placeholder="Search orders..." style="width: 250px;">
            </div>
        </div>

        <div class="table-responsive">
            <table id="orderAttributionTable" class="table table-hover align-middle mb-0" data-sort-dir="asc">
                <thead>
                    <tr>
                        <th class="ps-3 sortable-header" onclick="sortTable('orderAttributionTable', 0, false)">Order ID</th>
                        <th class="sortable-header" onclick="sortTable('orderAttributionTable', 1, false)">Name</th>
                        <th class="text-center sortable-header" onclick="sortTable('orderAttributionTable', 2, false)">Status</th>
                        <th class="text-center sortable-header" onclick="sortTable('orderAttributionTable', 3, true)">Amount</th>
                        <th class="sortable-header" onclick="sortTable('orderAttributionTable', 4, false)">Source</th>
                        <th class="sortable-header" onclick="sortTable('orderAttributionTable', 5, false)">Medium</th>
                        <th class="sortable-header" onclick="sortTable('orderAttributionTable', 6, false)">Campaign</th>
                        <th class="text-end pe-3 sortable-header" onclick="sortTable('orderAttributionTable', 7, false)">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders_data as $order)
                    <tr>
                        <td class="ps-3"><strong><i class="icofont-file-text text-secondary me-1"></i>{{ $order['order_number'] }}</strong></td>
                        <td>{{ $order['name'] }}</td>
                        <td class="text-center">
                            @if($order['status'] === 'paid')
                                <span class="badge bg-success">Paid</span>
                            @elseif($order['status'] === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-danger">{{ ucfirst($order['status']) }}</span>
                            @endif
                        </td>
                        <td class="text-center"><strong>${{ number_format($order['amount'], 2) }}</strong></td>
                        <td><strong>{{ $order['source'] }}</strong></td>
                        <td><span class="badge bg-secondary">{{ $order['medium'] }}</span></td>
                        <td><span class="text-muted">{{ $order['campaign'] }}</span></td>
                        <td class="text-end pe-3 text-secondary small">{{ $order['date'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No orders matching the current filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap mt-3 gap-2">
            <span id="orderPaginationInfo" class="text-secondary small">Showing 0 to 0 of 0 entries</span>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item" id="orderPrev"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item" id="orderNext"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Client-side instant sorting for tables
    function sortTable(tableId, colIndex, isNum = false) {
        const table = document.getElementById(tableId);
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        if (rows.length <= 1 && rows[0]?.querySelector('td')?.getAttribute('colspan')) return;
        
        let dir = table.getAttribute('data-sort-dir') === 'asc' ? 'desc' : 'asc';
        table.setAttribute('data-sort-dir', dir);
        
        // Reset sorting headers indicators
        const headers = table.querySelectorAll('.sortable-header');
        headers.forEach(h => {
            h.classList.remove('asc', 'desc');
        });
        
        const clickedHeader = headers[colIndex];
        if (clickedHeader) {
            clickedHeader.classList.add(dir);
        }
        
        rows.sort((a, b) => {
            let valA = a.cells[colIndex].textContent.replace(/[$,%]/g, '').trim();
            let valB = b.cells[colIndex].textContent.replace(/[$,%]/g, '').trim();
            
            if (isNum) {
                return dir === 'asc' ? parseFloat(valA) - parseFloat(valB) : parseFloat(valB) - parseFloat(valA);
            } else {
                return dir === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA);
            }
        });
        
        rows.forEach(row => tbody.appendChild(row));
        
        // Re-trigger rendering of current paginated list
        if (tableId === 'utmSummaryTable' && window.utmTableInstance) {
            window.utmTableInstance.refreshRows();
        } else if (tableId === 'orderAttributionTable' && window.orderTableInstance) {
            window.orderTableInstance.refreshRows();
        }
    }

    // Client-side pagination and search class
    class ClientTable {
        constructor(tableId, searchInputId, entriesSelectId, paginationInfoId, prevBtnId, nextBtnId) {
            this.table = document.getElementById(tableId);
            this.tbody = this.table.querySelector('tbody');
            this.allRows = Array.from(this.tbody.querySelectorAll('tr'));
            
            // Check if there is an empty data row
            if (this.allRows.length === 1 && this.allRows[0].querySelector('td').getAttribute('colspan')) {
                this.allRows = [];
            }
            
            this.filteredRows = [...this.allRows];
            
            this.searchInput = document.getElementById(searchInputId);
            this.entriesSelect = document.getElementById(entriesSelectId);
            this.paginationInfo = document.getElementById(paginationInfoId);
            this.prevBtn = document.getElementById(prevBtnId);
            this.nextBtn = document.getElementById(nextBtnId);
            
            this.currentPage = 1;
            this.pageSize = parseInt(this.entriesSelect.value) || 25;
            
            this.init();
        }
        
        init() {
            this.searchInput.addEventListener('input', () => {
                this.currentPage = 1;
                this.filter();
            });
            
            this.entriesSelect.addEventListener('change', () => {
                this.pageSize = parseInt(this.entriesSelect.value) || 25;
                this.currentPage = 1;
                this.render();
            });
            
            this.prevBtn.addEventListener('click', (e) => {
                e.preventDefault();
                if (this.currentPage > 1) {
                    this.currentPage--;
                    this.render();
                }
            });
            
            this.nextBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const totalPages = Math.ceil(this.filteredRows.length / this.pageSize);
                if (this.currentPage < totalPages) {
                    this.currentPage++;
                    this.render();
                }
            });
            
            this.filter();
        }
        
        refreshRows() {
            this.allRows = Array.from(this.tbody.querySelectorAll('tr'));
            this.filter();
        }
        
        filter() {
            const query = this.searchInput.value.toLowerCase().trim();
            
            if (!query) {
                this.filteredRows = [...this.allRows];
            } else {
                this.filteredRows = this.allRows.filter(row => {
                    const text = row.textContent.toLowerCase();
                    return text.includes(query);
                });
            }
            
            this.render();
        }
        
        render() {
            const totalRows = this.filteredRows.length;
            const totalPages = Math.ceil(totalRows / this.pageSize) || 1;
            
            if (this.currentPage > totalPages) {
                this.currentPage = totalPages;
            }
            
            const start = (this.currentPage - 1) * this.pageSize;
            const end = Math.min(start + this.pageSize, totalRows);
            
            // Hide all rows in the tbody
            this.allRows.forEach(row => row.style.display = 'none');
            
            // Show only active page rows
            for (let i = start; i < end; i++) {
                if (this.filteredRows[i]) {
                    this.filteredRows[i].style.display = '';
                }
            }
            
            // Update pagination info
            if (totalRows === 0) {
                this.paginationInfo.textContent = 'Showing 0 to 0 of 0 entries';
            } else {
                this.paginationInfo.textContent = `Showing ${start + 1} to ${end} of ${totalRows} entries`;
            }
            
            // Update button states
            this.prevBtn.classList.toggle('disabled', this.currentPage === 1);
            this.nextBtn.classList.toggle('disabled', this.currentPage === totalPages);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        window.utmTableInstance = new ClientTable(
            'utmSummaryTable',
            'utmSearch',
            'utmEntries',
            'utmPaginationInfo',
            'utmPrev',
            'utmNext'
        );
        
        window.orderTableInstance = new ClientTable(
            'orderAttributionTable',
            'orderSearch',
            'orderEntries',
            'orderPaginationInfo',
            'orderPrev',
            'orderNext'
        );
    });
</script>
@endsection
