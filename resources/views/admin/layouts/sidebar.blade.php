<div class="sidebar px-4 py-4 py-md-4 me-0">
    <div class="d-flex flex-column h-100">
        <a href="{{ route('admin.dashboard') }}" class="mb-0 brand-icon">
            <span class="logo-icon">
                <i class="bi icofont-education fs-4"></i>
            </span>
            <span class="logo-text">{{ session('admin_company', 'CEUTrainers') }}</span>
        </a>
        
        <!-- Menu: main ul -->
        <ul class="menu-list flex-grow-1 mt-3">
            <li><a class="m-link" href="{{ route('admin.dashboard') }}"><i class="icofont-home fs-5"></i> <span>Dashboard</span></a></li>
            <li><a class="m-link" href="{{ route('admin.page', 'Industries') }}"><i class="icofont-certificate-alt-1 fs-5"></i><span>Industries</span></a></li>
            <li><a class="m-link" href="{{ route('admin.page', 'Selling-options') }}"><i class="icofont-money-bag fs-5"></i><span>Selling options</span></a></li>
            <li><a class="m-link" href="{{ route('admin.subscription-plans.index') }}"><i class="icofont-refresh fs-5"></i><span>Subscriptions</span></a></li>
            <li><a class="m-link" href="{{ route('admin.testimonials.index') }}"><i class="icofont-quote-left fs-5"></i><span>Testimonials</span></a></li>
            
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#course" href="#">
                    <i class="icofont-book-alt fs-5"></i> <span>Courses</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span>
                </a>
                <ul class="sub-menu collapse" id="course">
                    <li><a class="ms-link" href="{{ route('admin.page', 'course-list') }}">Course List</a></li>
                    <li><a class="ms-link" href="{{ route('admin.page', 'course-add') }}">Add Course</a></li>
                </ul>
            </li>
            
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#speaker" href="#">
                    <i class="icofont-teacher fs-5"></i> <span>Speakers</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span>
                </a>
                <ul class="sub-menu collapse" id="speaker">
                    <li><a class="ms-link" href="{{ route('admin.page', 'speaker') }}">Speakers list</a></li>
                    <li><a class="ms-link" href="{{ route('admin.page', 'Become-A-speaker') }}">Become A speaker</a></li>
                </ul>
            </li>

            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#customers-info" href="#">
                    <i class="icofont-users-social fs-5"></i> <span>Users</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span>
                </a>
                <ul class="sub-menu collapse" id="customers-info">
                    <li><a class="ms-link" href="{{ route('admin.page', 'customers') }}">All Users</a></li>
                </ul>
            </li>

            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#menu-order" href="#">
                    <i class="icofont-notepad fs-5"></i> <span>Orders </span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span>
                </a>
                <ul class="sub-menu collapse" id="menu-order">
                    <li><a class="ms-link" href="{{ route('admin.page', 'order-list') }}">Orders List</a></li>
                    <!-- <li><a class="ms-link" href="{{ route('admin.page', 'order-invoices') }}">Order Invoices</a></li> -->
                    <li><a class="ms-link" href="{{ route('admin.campaign.report') }}">Campaign Report</a></li>
                </ul>
            </li>

            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#FAQcategories" href="#">
                    <i class="icofont-support-faq fs-5"></i> <span>FAQ</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span>
                </a>
                <ul class="sub-menu collapse" id="FAQcategories">
                    <li><a class="ms-link" href="{{ route('admin.page', 'faq-categories-add') }}">Add category</a></li>
                    <li><a class="ms-link" href="{{ route('admin.page', 'faq-categorie-list') }}">FAQ List</a></li>
                </ul>
            </li>
            
            <li>
                <a class="m-link" href="{{ route('admin.page', 'coupons-list') }}">
                    <i class="icofont-sale-discount fs-5"></i> <span>Sales Promotion</span>
                </a>
            </li>
            
            <li><a class="m-link" href="{{ route('admin.page', 'contact') }}"><i class="icofont-address-book fs-5"></i> <span>Contact form</span></a></li>
            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#settings" href="#">
                    <i class="icofont-ui-settings fs-5"></i> <span>System Settings </span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span>
                </a>
                <ul class="sub-menu collapse" id="settings">
                    <li><a class="ms-link" href="{{ route('admin.page', 'smtp-settings') }}">SMTP Setup</a></li>
                    <li><a class="ms-link" href="{{ route('admin.page', 'payment-settings') }}">Payment Gateways</a></li>
                </ul>
            </li>
            <!-- <li><a class="m-link" href="{{ route('admin.page', 'wp_order_details') }}"><i class="icofont-address-book fs-5"></i> <span>order_details Wp</span></a></li> -->
        </ul>
        
        <!-- Menu: mini collapse button -->
        <button type="button" class="btn btn-link sidebar-mini-btn text-light">
            <span class="ms-2"><i class="icofont-bubble-right"></i></span>
        </button>
    </div>
</div>
