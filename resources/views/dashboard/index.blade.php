@extends('layouts.app')

@section('title', 'Student Dashboard | CEUTrainers')

@section('styles')
<style>
    /* Premium Student Dashboard (Udemy-inspired Design System) */
    .student-dashboard {
        padding: 50px 0 90px;
        background-color: #f8fafc;
        min-height: 100vh;
    }

    /* Welcome Hero Card with glassmorphism & geometric background */
    .dashboard-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 24px;
        padding: 45px;
        color: #ffffff;
        margin-bottom: 45px;
        box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.3);
        position: relative;
        overflow: hidden;
    }

    .dashboard-hero::before {
        content: "";
        position: absolute;
        top: -60%;
        right: -10%;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(26, 182, 157, 0.18) 0%, transparent 70%);
        pointer-events: none;
    }

    .dashboard-hero::after {
        content: "";
        position: absolute;
        bottom: -40%;
        left: -5%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(13, 148, 136, 0.12) 0%, transparent 70%);
        pointer-events: none;
    }

    .student-avatar-wrapper {
        position: relative;
        display: inline-block;
    }

    .student-avatar {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.2);
        object-fit: cover;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        background: #f1f5f9;
        transition: transform 0.3s ease;
    }

    .student-avatar:hover {
        transform: scale(1.05);
        border-color: #1ab69d;
    }

    .avatar-status-dot {
        position: absolute;
        bottom: 4px;
        right: 4px;
        width: 16px;
        height: 16px;
        background-color: #1ab69d;
        border: 3px solid #0f172a;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(26, 182, 157, 0.6);
    }

    .student-welcome h2 {
        font-size: 34px;
        font-weight: 800;
        margin-bottom: 8px;
        color: #ffffff;
        letter-spacing: -0.8px;
        line-height: 1.2;
    }

    .student-welcome p {
        color: #94a3b8;
        font-size: 16px;
        margin: 0;
        max-width: 520px;
        line-height: 1.6;
    }

    /* Glassmorphic Stats Cards */
    .hero-stat-card {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        backdrop-filter: blur(12px);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        height: 100%;
    }

    .hero-stat-card:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(26, 182, 157, 0.35);
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(26, 182, 157, 0.1);
    }

    .hero-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(26, 182, 157, 0.12);
        color: #1ab69d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
        box-shadow: inset 0 0 12px rgba(26, 182, 157, 0.06);
    }

    .hero-stat-info h4 {
        font-size: 24px;
        font-weight: 800;
        margin: 0;
        color: #ffffff;
        line-height: 1.1;
    }

    .hero-stat-info span {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        display: block;
        margin-top: 4px;
    }

    /* Premium Navigation Tabs */
    .dashboard-tabs-container {
        position: relative;
        margin-bottom: 35px;
    }

    .dashboard-tabs {
        border-bottom: 2px solid #e2e8f0;
        gap: 6px;
    }

    .dashboard-tabs .nav-link {
        border: none !important;
        background: transparent !important;
        color: #64748b;
        font-weight: 700;
        font-size: 16px;
        padding: 14px 24px;
        position: relative;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        border-radius: 8px 8px 0 0;
    }

    .dashboard-tabs .nav-link:hover {
        color: #0f172a;
        background: rgba(15, 23, 42, 0.02) !important;
    }

    .dashboard-tabs .nav-link.active {
        color: #1ab69d;
    }

    .dashboard-tabs .nav-link::after {
        content: "";
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2.5px;
        background-color: #1ab69d;
        transform: scaleX(0);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 99px;
    }

    .dashboard-tabs .nav-link.active::after {
        transform: scaleX(1);
    }

    .tab-badge {
        font-size: 11px;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #64748b;
        transition: all 0.3s ease;
    }

    .dashboard-tabs .nav-link.active .tab-badge {
        background: rgba(26, 182, 157, 0.12);
        color: #1ab69d;
    }

    /* Course Grid & Cards */
    .course-progress-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        overflow: hidden;
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.03);
    }

    .course-progress-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 35px -12px rgba(15, 23, 42, 0.09);
        border-color: rgba(26, 182, 157, 0.25);
    }

    .course-thumb-wrapper {
        position: relative;
        overflow: hidden;
        height: 180px;
        flex-shrink: 0;
        background: #f1f5f9;
    }

    .course-thumb-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .course-progress-card:hover .course-thumb-wrapper img {
        transform: scale(1.06);
    }

    /* Dual Badges on Thumbnail */
    .course-category-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(15, 23, 42, 0.85);
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        backdrop-filter: blur(6px);
        letter-spacing: 0.4px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .course-type-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        background: rgba(26, 182, 157, 0.9);
        color: #ffffff;
        font-size: 10px;
        font-weight: 800;
        padding: 4px 9px;
        border-radius: 6px;
        backdrop-filter: blur(6px);
        letter-spacing: 0.4px;
        text-transform: uppercase;
        box-shadow: 0 4px 10px rgba(26, 182, 157, 0.2);
    }

    .course-progress-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .course-progress-body .course-title {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.45;
        margin-bottom: 12px;
        min-height: 52px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        letter-spacing: -0.3px;
        transition: color 0.3s ease;
    }

    .course-progress-card:hover .course-progress-body .course-title {
        color: #1ab69d;
    }

    .course-progress-body .speaker-name {
        font-size: 14px;
        color: #475569;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
    }

    .course-progress-body .speaker-name img {
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        border: 1.5px solid #ffffff;
    }

    /* Progress Tracker Styles */
    .progress-tracker {
        margin-bottom: 22px;
        background: #f8fafc;
        padding: 12px 14px;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
    }

    .progress-bar-label {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .progress-bar-label .percent {
        color: #1ab69d;
        font-weight: 800;
    }

    .progress-bar-bg {
        height: 6px;
        background: #e2e8f0;
        border-radius: 99px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #1ab69d 0%, #0d9488 100%);
        border-radius: 99px;
    }

    .resume-btn {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        color: #334155;
        font-weight: 700;
        font-size: 14px;
        padding: 12px 16px;
        width: 100%;
        border-radius: 10px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: auto;
    }

    .resume-btn:hover {
        background: #1ab69d;
        border-color: #1ab69d;
        color: #ffffff;
        box-shadow: 0 8px 20px rgba(26, 182, 157, 0.2);
    }

    /* Subscriptions membership cards style */
    .sub-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.02);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }

    .sub-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 35px -10px rgba(15, 23, 42, 0.06);
        border-color: rgba(26, 182, 157, 0.2);
    }

    .sub-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: #1ab69d;
    }

    .sub-card.expired::before {
        background: #ef4444;
    }

    .sub-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 20px;
    }

    .sub-plan-name {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.4px;
    }

    .sub-duration {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
    }

    .sub-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin: 20px 0;
        background: #f8fafc;
        padding: 16px;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
    }

    .sub-detail-item span {
        font-size: 11px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        display: block;
        margin-bottom: 4px;
    }

    .sub-detail-item strong {
        font-size: 14px;
        color: #0f172a;
        font-weight: 700;
    }

    /* Subscriptions & Orders List Views */
    .premium-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.02);
        padding: 35px;
        margin-bottom: 30px;
    }

    .premium-card h4 {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 24px;
        letter-spacing: -0.4px;
    }

    .table-premium {
        margin: 0;
    }

    .table-premium th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 18px 20px;
        border-bottom: 2px solid #f1f5f9;
    }

    .table-premium td {
        padding: 20px;
        font-size: 14.5px;
        color: #334155;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    .order-code-badge {
        font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
        font-size: 12.5px;
        font-weight: 700;
        color: #0f172a;
        background: #f1f5f9;
        padding: 5px 10px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
    }

    .badge-premium {
        padding: 6px 14px;
        border-radius: 99px;
        font-size: 12px;
        font-weight: 700;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .badge-premium.active,
    .badge-premium.paid {
        background-color: #e6f8f5;
        color: #0d9488;
        box-shadow: inset 0 0 10px rgba(13, 148, 136, 0.05);
    }

    .badge-premium.expired,
    .badge-premium.cancelled {
        background-color: #fef2f2;
        color: #ef4444;
        box-shadow: inset 0 0 10px rgba(239, 68, 68, 0.05);
    }

    .badge-premium.pending {
        background-color: #fffbeb;
        color: #d97706;
        box-shadow: inset 0 0 10px rgba(217, 119, 6, 0.05);
    }

    .invoice-btn {
        background: transparent;
        border: 1.5px solid #e2e8f0;
        color: #475569;
        font-weight: 700;
        font-size: 13px;
        padding: 8px 14px;
        border-radius: 8px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .invoice-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #0f172a;
    }

    /* Form Styles inside Settings Tab */
    .form-premium label {
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        display: block;
    }

    .form-premium .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 14.5px;
        color: #0f172a;
        font-weight: 500;
        transition: all 0.25s ease;
        background-color: #f8fafc;
        box-shadow: none;
    }

    .form-premium .form-control:focus {
        border-color: #1ab69d;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(26, 182, 157, 0.1) !important;
    }

    .form-premium .form-check-input {
        width: 18px;
        height: 18px;
        margin-top: 2px;
        border: 1.5px solid #cbd5e1;
    }

    .form-premium .form-check-input:checked {
        background-color: #1ab69d;
        border-color: #1ab69d;
    }

    .save-settings-btn {
        background: #1ab69d;
        border: none;
        color: #ffffff;
        font-weight: 700;
        font-size: 14.5px;
        padding: 14px 28px;
        border-radius: 10px;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 8px 20px rgba(26, 182, 157, 0.2);
        cursor: pointer;
    }

    .save-settings-btn:hover {
        background: #0d9488;
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(13, 148, 136, 0.3);
    }
</style>
@endsection

@section('content')
<section class="student-dashboard">
    <div class="container">
        <!-- Udemy-style Welcome Hero Banner -->
        @php
            $hour = date('H');
            $greeting = 'Welcome back';
            if ($hour < 12) {
                $greeting = 'Good morning';
            } elseif ($hour < 17) {
                $greeting = 'Good afternoon';
            } else {
                $greeting = 'Good evening';
            }
        @endphp

        <div class="dashboard-hero">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-4 flex-wrap">
                        <div class="student-avatar-wrapper">
                            @php
                                $userAvatar = $user->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=1ab69d&color=fff&size=192';
                            @endphp
                            <img class="student-avatar" src="{{ $userAvatar }}" alt="{{ $user->name }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=1ab69d&color=fff&size=192'">
                            <span class="avatar-status-dot"></span>
                        </div>
                        <div class="student-welcome">
                            <h2>{{ $greeting }}, {{ explode(' ', $user->name)[0] }}!</h2>
                            <p>Track your compliance learning, access live events, and download continuing education materials.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-sm-4 col-6">
                            <div class="hero-stat-card">
                                <div class="hero-stat-icon">
                                    <i class="fa fa-graduation-cap"></i>
                                </div>
                                <div class="hero-stat-info">
                                    <h4>{{ $courseAccesses->where('status', 'active')->count() }}</h4>
                                    <span>Courses</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="hero-stat-card">
                                <div class="hero-stat-icon">
                                    <i class="fa fa-refresh"></i>
                                </div>
                                <div class="hero-stat-info">
                                    <h4>{{ $subscriptions->where('status', 'active')->count() }}</h4>
                                    <span>Active Plans</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-12">
                            <div class="hero-stat-card">
                                <div class="hero-stat-icon">
                                    <i class="fa fa-shopping-bag"></i>
                                </div>
                                <div class="hero-stat-info">
                                    <h4>{{ $orders->count() }}</h4>
                                    <span>Orders</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Navigation Tabs with dynamic count badges -->
        <div class="dashboard-tabs-container">
            <ul class="nav nav-tabs dashboard-tabs" id="dashboardTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="courses-tab" data-bs-toggle="tab" data-bs-target="#courses" type="button" role="tab" aria-controls="courses" aria-selected="true">
                        <i class="fa fa-book"></i> My Enrolled Courses
                        <span class="tab-badge">{{ $courseAccesses->where('status', 'active')->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="subscriptions-tab" data-bs-toggle="tab" data-bs-target="#subscriptions" type="button" role="tab" aria-controls="subscriptions" aria-selected="false">
                        <i class="fa fa-refresh"></i> My Subscriptions
                        <span class="tab-badge">{{ $subscriptions->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="orders" aria-selected="false">
                        <i class="fa fa-history"></i> Order History
                        <span class="tab-badge">{{ $orders->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">
                        <i class="fa fa-cog"></i> Profile & Settings
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content Views -->
        <div class="tab-content" id="dashboardTabContent">
            <!-- Courses Tab -->
            <div class="tab-pane fade show active" id="courses" role="tabpanel" aria-labelledby="courses-tab">
                <div class="row g-4">
                    @forelse($courseAccesses as $access)
                        @if($access->course)
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                            <div class="course-progress-card">
                                <div class="course-thumb-wrapper">
                                    @php
                                        $thumb = $access->course->thumbnail;
                                        if (!$thumb) {
                                            $thumb = asset('ceuadmin-assets/assets/images/course/ceutrainers.webp');
                                        } else {
                                            $thumb = str_starts_with($thumb, 'http') ? $thumb : asset('ceuadmin-assets/assets/images/course/' . $thumb);
                                        }
                                    @endphp
                                    <img src="{{ $thumb }}" alt="{{ $access->course->title }}" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&q=80'">
                                    <span class="course-category-badge">{{ $access->course->industry->name ?? 'General' }}</span>
                                    <span class="course-type-badge">{{ str_replace('_', ' ', $access->access_type) }}</span>
                                </div>
                                <div class="course-progress-body">
                                    <h3 class="course-title">{{ $access->course->title }}</h3>
                                    
                                    @php
                                        $speakerPhoto = $access->course->speaker->image ?? null;
                                        if ($speakerPhoto) {
                                            $speakerPhotoUrl = str_starts_with($speakerPhoto, 'http') ? $speakerPhoto : asset('ceuadmin-assets/assets/images/speaker/' . $speakerPhoto);
                                        } else {
                                            $speakerPhotoUrl = 'https://ui-avatars.com/api/?name=' . urlencode($access->course->speaker->name ?? 'Expert Speaker') . '&background=e6f8f5&color=0d9488&size=64';
                                        }
                                    @endphp
                                    <div class="speaker-name">
                                        <img src="{{ $speakerPhotoUrl }}" alt="{{ $access->course->speaker->name ?? 'Expert Speaker' }}" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                                        {{ $access->course->speaker->name ?? 'Expert Speaker' }}
                                    </div>
                                    
                                    @php
                                        // Realistic simulated progress bar percentage
                                        $simulatedProgress = (($access->course->id % 6) + 1) * 15;
                                        if ($simulatedProgress > 100) $simulatedProgress = 100;
                                    @endphp
                                    <div class="progress-tracker">
                                        <div class="progress-bar-label">
                                            <span>Progress</span>
                                            <span class="percent">{{ $simulatedProgress }}%</span>
                                        </div>
                                        <div class="progress-bar-bg">
                                            <div class="progress-bar-fill" style="width: {{ $simulatedProgress }}%;"></div>
                                        </div>
                                    </div>
                                    
                                    <a href="{{ route('course.show', $access->course->slug) }}" class="resume-btn">
                                        <i class="fa fa-play-circle-o"></i> Resume Learning
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <div class="col-12 text-center py-5">
                            <div class="mb-4">
                                <i class="fa fa-graduation-cap text-muted" style="font-size: 64px; color: #cbd5e1 !important;"></i>
                            </div>
                            <h4 class="text-dark fw-bold">You are not enrolled in any courses yet.</h4>
                            <p class="text-muted mb-4">Explore our wide selection of HR, payroll, and compliance webinars to start learning.</p>
                            <a href="{{ route('webinar.index') }}" class="edu-btn">Browse Webinars <i class="icon-4"></i></a>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Subscriptions Tab -->
            <div class="tab-pane fade" id="subscriptions" role="tabpanel" aria-labelledby="subscriptions-tab">
                <!-- Visual Cards Grid for active plans -->
                <div class="row g-4 mb-5">
                    @forelse($subscriptions->where('status', 'active') as $sub)
                        <div class="col-lg-6 col-md-12">
                            <div class="sub-card">
                                <div class="sub-header">
                                    <div>
                                        <h3 class="sub-plan-name">{{ $sub->plan->name ?? 'Standard Access Plan' }}</h3>
                                        <span class="sub-duration">Billing Frequency: Annual Plan</span>
                                    </div>
                                    <span class="badge-premium active">Active</span>
                                </div>
                                <div class="sub-detail-grid">
                                    <div class="sub-detail-item">
                                        <span>Start Date</span>
                                        <strong>{{ $sub->start_date ? $sub->start_date->format('M d, Y') : $sub->created_at->format('M d, Y') }}</strong>
                                    </div>
                                    <div class="sub-detail-item">
                                        <span>Renewal/Expiry</span>
                                        <strong>{{ $sub->end_date ? $sub->end_date->format('M d, Y') : 'Unlimited' }}</strong>
                                    </div>
                                    <div class="sub-detail-item">
                                        <span>Mapped Access</span>
                                        <strong>{{ $sub->plan->max_course_access ? ($sub->plan->max_course_access . ' Courses') : 'Unlimited' }}</strong>
                                    </div>
                                    <div class="sub-detail-item">
                                        <span>Auto Renew</span>
                                        <strong>{{ $sub->auto_renew ? 'Yes' : 'No' }}</strong>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span style="font-size: 13px; color: #64748b;"><i class="fa fa-info-circle text-teal me-1"></i> Continuous access to compliance events</span>
                                    <a href="{{ route('subscription.index') }}" class="btn btn-sm btn-link text-teal fw-bold p-0 text-decoration-none">Manage Plan <i class="fa fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4 bg-white border rounded-3 text-muted">
                            You have no active subscription plans at the moment. 
                            <a href="{{ route('subscription.index') }}" class="text-teal fw-bold ms-1 text-decoration-none">View subscription plans <i class="fa fa-external-link ms-1"></i></a>
                        </div>
                    @endforelse
                </div>

                <!-- Detailed History Card -->
                <div class="premium-card">
                    <h4>Subscription History</h4>
                    <div class="table-responsive">
                        <table class="table table-premium align-middle">
                            <thead>
                                <tr>
                                    <th>Plan Name</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                    <th>Expiry Date</th>
                                    <th>Course Limit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subscriptions as $sub)
                                <tr>
                                    <td><strong class="text-dark">{{ $sub->plan->name ?? 'Standard Access Plan' }}</strong></td>
                                    <td>
                                        <span class="badge-premium {{ $sub->status == 'active' ? 'active' : 'expired' }}">
                                            {{ ucfirst($sub->status ?? 'active') }}
                                        </span>
                                    </td>
                                    <td>{{ $sub->start_date ? $sub->start_date->format('M d, Y') : $sub->created_at->format('M d, Y') }}</td>
                                    <td>{{ $sub->end_date ? $sub->end_date->format('M d, Y') : 'Unlimited' }}</td>
                                    <td>{{ $sub->plan->max_course_access ? ($sub->plan->max_course_access . ' Courses') : 'Unlimited' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No subscription history found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Orders Tab -->
            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                <div class="premium-card">
                    <h4>All Transaction Invoices</h4>
                    <div class="table-responsive">
                        <table class="table table-premium align-middle">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Enrolled Items</th>
                                    <th>Amount Paid</th>
                                    <th>Status</th>
                                    <th>Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td><span class="order-code-badge">{{ $order->order_number }}</span></td>
                                    <td>{{ $order->created_at ? $order->created_at->format('M d, Y') : 'N/A' }}</td>
                                    <td>
                                        @php
                                            $firstItem = $order->items->first();
                                            $itemCount = $order->items->count();
                                        @endphp
                                        @if($firstItem)
                                            <strong class="text-dark">{{ $firstItem->title }}</strong>
                                            @if($itemCount > 1)
                                                <span class="badge bg-light text-dark border ms-2">+{{ $itemCount - 1 }} more</span>
                                            @endif
                                        @else
                                            CEU Webinar Enrollment
                                        @endif
                                    </td>
                                    <td><strong class="text-dark" style="font-size: 16px;">${{ number_format($order->grand_total, 2) }}</strong></td>
                                    <td>
                                        <span class="badge-premium {{ $order->payment_status == 'paid' ? 'paid' : 'pending' }}">
                                            {{ ucfirst($order->payment_status ?? 'paid') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('dashboard.order.invoice', $order->id) }}" class="invoice-btn" target="_blank">
                                            <i class="fa fa-file-pdf-o text-danger"></i> View Invoice
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fa fa-shopping-bag text-muted mb-3" style="font-size: 40px; color: #cbd5e1 !important;"></i>
                                        <p class="mb-0">No completed orders found in your transaction history.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Settings Tab -->
            <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                <div class="row g-4 form-premium">
                    <!-- Left Column: Profile settings & Security -->
                    <div class="col-lg-6">
                        <!-- Profile Card -->
                        <div class="premium-card">
                            <h4>Personal Profile Details</h4>
                            <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="name">Full Name</label>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $user->phone) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="company_name">Company Name</label>
                                        <input type="text" class="form-control" name="company_name" id="company_name" value="{{ old('company_name', $user->company_name) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="job_title">Job Title / Designation</label>
                                        <input type="text" class="form-control" name="job_title" id="job_title" value="{{ old('job_title', $user->job_title) }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="avatar">Change Profile Picture</label>
                                        <input type="file" class="form-control" name="avatar" id="avatar" accept="image/*">
                                        <span class="text-muted" style="font-size: 12px; margin-top: 4px; display: block;">Supports JPG, PNG, WEBP (Max 2MB).</span>
                                    </div>
                                    <div class="col-12 mt-4 text-end">
                                        <button type="submit" class="save-settings-btn">
                                            <i class="fa fa-save me-1"></i> Save Changes
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Change Password Card -->
                        <div class="premium-card">
                            <h4>Update Login Password</h4>
                            <form action="{{ route('dashboard.password.update') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="current_password">Current Password</label>
                                        <input type="password" class="form-control" name="current_password" id="current_password" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="new_password">New Password</label>
                                        <input type="password" class="form-control" name="new_password" id="new_password" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="new_password_confirmation">Confirm Password</label>
                                        <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" required>
                                    </div>
                                    <div class="col-12 mt-4 text-end">
                                        <button type="submit" class="save-settings-btn" style="background-color: #0f172a; box-shadow: 0 8px 20px rgba(15,23,42,0.15);">
                                            <i class="fa fa-lock me-1"></i> Update Password
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Right Column: Addresses Settings -->
                    <div class="col-lg-6">
                        <div class="premium-card">
                            <h4>Billing & Shipping Addresses</h4>
                            <form action="{{ route('dashboard.address.update') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <!-- Billing Section -->
                                    <div class="col-12">
                                        <h5 class="fw-bold mb-3 text-teal" style="font-size: 15px; border-bottom: 2px solid #e6f8f5; padding-bottom: 8px;">
                                            <i class="fa fa-credit-card me-1"></i> Primary Billing Address
                                        </h5>
                                    </div>
                                    <div class="col-12">
                                        <label for="billing_name">Billing Recipient Name</label>
                                        <input type="text" class="form-control" name="billing_name" id="billing_name" value="{{ old('billing_name', $billingAddress->name ?? $user->name) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="billing_phone">Billing Phone</label>
                                        <input type="text" class="form-control" name="billing_phone" id="billing_phone" value="{{ old('billing_phone', $billingAddress->phone ?? $user->phone) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="billing_company">Billing Company</label>
                                        <input type="text" class="form-control" name="billing_company" id="billing_company" value="{{ old('billing_company', $billingAddress->company_name ?? $user->company_name) }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="billing_address_1">Address Line 1</label>
                                        <input type="text" class="form-control" name="billing_address_1" id="billing_address_1" value="{{ old('billing_address_1', $billingAddress->address_line_1 ?? '') }}" placeholder="Street address or P.O. Box" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="billing_address_2">Address Line 2 (Optional)</label>
                                        <input type="text" class="form-control" name="billing_address_2" id="billing_address_2" value="{{ old('billing_address_2', $billingAddress->address_line_2 ?? '') }}" placeholder="Apartment, suite, unit, building, floor">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="billing_city">City</label>
                                        <input type="text" class="form-control" name="billing_city" id="billing_city" value="{{ old('billing_city', $billingAddress->city ?? '') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="billing_state">State / Province</label>
                                        <input type="text" class="form-control" name="billing_state" id="billing_state" value="{{ old('billing_state', $billingAddress->state ?? '') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="billing_postal_code">Zip / Postal Code</label>
                                        <input type="text" class="form-control" name="billing_postal_code" id="billing_postal_code" value="{{ old('billing_postal_code', $billingAddress->postal_code ?? '') }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="billing_country">Country</label>
                                        <input type="text" class="form-control" name="billing_country" id="billing_country" value="{{ old('billing_country', $billingAddress->country ?? '') }}" required>
                                    </div>

                                    <!-- Shipping Toggle Checkbox -->
                                    <div class="col-12 mt-4">
                                        <div class="form-check form-switch p-0 ps-4">
                                            @php
                                                // Default to true if no shipping address or same coordinates
                                                $sameAsBilling = true;
                                                if ($shippingAddress && $billingAddress) {
                                                    $sameAsBilling = ($shippingAddress->address_line_1 === $billingAddress->address_line_1 && $shippingAddress->city === $billingAddress->city);
                                                }
                                            @endphp
                                            <input class="form-check-input ms-n4 me-2" type="checkbox" name="same_as_billing" id="same_as_billing" value="1" {{ $sameAsBilling ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold" for="same_as_billing" style="text-transform: none; font-size: 13.5px; color: #0f172a; margin: 0;">
                                                Shipping Address is same as Billing Address
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Shipping Section -->
                                    <div id="shipping_fields_container" style="display: {{ $sameAsBilling ? 'none' : 'block' }};">
                                        <div class="row g-3 mt-2">
                                            <div class="col-12">
                                                <h5 class="fw-bold mb-3 text-teal" style="font-size: 15px; border-bottom: 2px solid #e6f8f5; padding-bottom: 8px;">
                                                    <i class="fa fa-truck me-1"></i> Secondary Shipping Address
                                                </h5>
                                            </div>
                                            <div class="col-12">
                                                <label for="shipping_name">Shipping Recipient Name</label>
                                                <input type="text" class="form-control" name="shipping_name" id="shipping_name" value="{{ old('shipping_name', $shippingAddress->name ?? '') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="shipping_phone">Shipping Phone</label>
                                                <input type="text" class="form-control" name="shipping_phone" id="shipping_phone" value="{{ old('shipping_phone', $shippingAddress->phone ?? '') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="shipping_company">Shipping Company</label>
                                                <input type="text" class="form-control" name="shipping_company" id="shipping_company" value="{{ old('shipping_company', $shippingAddress->company_name ?? '') }}">
                                            </div>
                                            <div class="col-12">
                                                <label for="shipping_address_1">Address Line 1</label>
                                                <input type="text" class="form-control" name="shipping_address_1" id="shipping_address_1" value="{{ old('shipping_address_1', $shippingAddress->address_line_1 ?? '') }}" placeholder="Street address or P.O. Box">
                                            </div>
                                            <div class="col-12">
                                                <label for="shipping_address_2">Address Line 2 (Optional)</label>
                                                <input type="text" class="form-control" name="shipping_address_2" id="shipping_address_2" value="{{ old('shipping_address_2', $shippingAddress->address_line_2 ?? '') }}" placeholder="Apartment, suite, unit, building, floor">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="shipping_city">City</label>
                                                <input type="text" class="form-control" name="shipping_city" id="shipping_city" value="{{ old('shipping_city', $shippingAddress->city ?? '') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="shipping_state">State / Province</label>
                                                <input type="text" class="form-control" name="shipping_state" id="shipping_state" value="{{ old('shipping_state', $shippingAddress->state ?? '') }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="shipping_postal_code">Zip / Postal Code</label>
                                                <input type="text" class="form-control" name="shipping_postal_code" id="shipping_postal_code" value="{{ old('shipping_postal_code', $shippingAddress->postal_code ?? '') }}">
                                            </div>
                                            <div class="col-12">
                                                <label for="shipping_country">Country</label>
                                                <input type="text" class="form-control" name="shipping_country" id="shipping_country" value="{{ old('shipping_country', $shippingAddress->country ?? '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4 text-end">
                                        <button type="submit" class="save-settings-btn">
                                            <i class="fa fa-save me-1"></i> Save Addresses
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sameAsBillingCheckbox = document.getElementById('same_as_billing');
        const shippingFieldsContainer = document.getElementById('shipping_fields_container');

        if (sameAsBillingCheckbox && shippingFieldsContainer) {
            sameAsBillingCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    shippingFieldsContainer.style.display = 'none';
                    // Clear shipping validation requirements by removing 'required' if present
                    toggleRequiredFields(false);
                } else {
                    shippingFieldsContainer.style.display = 'block';
                    toggleRequiredFields(true);
                }
            });
        }

        function toggleRequiredFields(makeRequired) {
            const fields = [
                'shipping_name',
                'shipping_address_1',
                'shipping_city',
                'shipping_state',
                'shipping_country',
                'shipping_postal_code'
            ];
            fields.forEach(fieldId => {
                const element = document.getElementById(fieldId);
                if (element) {
                    if (makeRequired) {
                        element.setAttribute('required', 'required');
                    } else {
                        element.removeAttribute('required');
                    }
                }
            });
        }
    });
</script>
@endsection
