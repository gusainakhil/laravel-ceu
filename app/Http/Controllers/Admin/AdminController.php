<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        // Native Laravel authentication protect middleware for /ceuadmin
        $this->middleware(function ($request, $next) {
            $path = $request->path();
            if ($path !== 'ceuadmin/login') {
                if (!Auth::check()) {
                    return redirect()->route('admin.login');
                }
                if (!Auth::user()->isManager()) {
                    Auth::logout();
                    return redirect()->route('admin.login')->withErrors(['email' => 'Unauthorized admin access.']);
                }
            } else {
                if (Auth::check() && Auth::user()->isManager()) {
                    return redirect()->route('admin.dashboard');
                }
            }
            return $next($request);
        });
    }

    /**
     * Display the Admin Login form
     */
    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Handle Admin Login Submission
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            if ($user->isManager()) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Unauthorized admin access.',
                ])->onlyInput('username');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    /**
     * Handle Admin Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    /**
     * Render the Admin Dashboard
     */
    public function dashboard()
    {
        $total_orders = \App\Models\Order::count();
        $total_revenue = \App\Models\Order::where('payment_status', 'paid')->sum('grand_total');
        $total_customers = \App\Models\User::where('role', 'customer')->count();
        $total_speakers = \App\Models\Speaker::count();
        $total_webinars = \App\Models\Course::count();

        // Calculate today's, this week's, and this month's revenue dynamically
        $today_revenue = \App\Models\Order::where('payment_status', 'paid')
            ->whereDate('created_at', Carbon::today())
            ->sum('grand_total');
            
        $week_revenue = \App\Models\Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('grand_total');
            
        $month_revenue = \App\Models\Order::where('payment_status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('grand_total');

        $average_sale = $total_orders > 0 ? ($total_revenue / $total_orders) : 0;

        $topSellingItem = \App\Models\OrderItem::query()
            ->select('order_items.title')
            ->selectRaw('SUM(order_items.quantity) as sold_quantity')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'paid')
            ->where('order_items.item_type', 'course')
            ->groupBy('order_items.course_id', 'order_items.title')
            ->orderByDesc('sold_quantity')
            ->orderByDesc('order_items.title')
            ->first();

        $recentOrders = \App\Models\Order::with('items')->latest()->limit(10)->get();
        $orders = [];
        foreach ($recentOrders as $o) {
            $firstItem = $o->items->first();
            $orders[] = [
                'id' => $o->id,
                'order_id' => $o->order_number,
                'title' => $firstItem ? $firstItem->title : 'CEU Webinar Order',
                'amount' => (float)$o->grand_total,
                'selling_options' => $firstItem ? ($firstItem->description ?? 'Standard Registration') : 'N/A',
                'trans_date' => $o->created_at->format('Y-m-d H:i:s'),
                'payment_status' => $o->payment_status === 'paid' ? 'completed' : 'Incomplete',
            ];
        }

        $data = [
            'total_orders' => $total_orders,
            'total_revenue' => (float)$total_revenue,
            'total_customers' => $total_customers,
            'total_speakers' => $total_speakers,
            'total_webinars' => $total_webinars,
            'today_revenue' => (float)$today_revenue,
            'week_revenue' => (float)$week_revenue,
            'month_revenue' => (float)$month_revenue,
            'average_sale' => (float)$average_sale,
            'top_selling_item' => $topSellingItem->title ?? 'No course sales yet',
            'top_selling_quantity' => (int)($topSellingItem->sold_quantity ?? 0),
            'orders' => $orders,
            
            'today_sales' => \App\Models\Order::where('payment_status', 'paid')->whereDate('created_at', Carbon::today())->count(),
            'week_sales' => \App\Models\Order::where('payment_status', 'paid')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            'month_sales' => \App\Models\Order::where('payment_status', 'paid')->whereMonth('created_at', Carbon::now()->month)->count(),
            'year_sales' => \App\Models\Order::where('payment_status', 'paid')->count(),
            'year_revenue' => (float)$total_revenue,
        ];

        return view('admin.index', $data);
    }

    /**
     * Render dynamic administrative sub-pages
     */
    public function renderPage($page)
    {
        $page = str_replace('.php', '', $page);
        $page = strtolower($page);

        if ($page === 'campaign-report') {
            return $this->campaignReport(request());
        }

        $viewName = "admin.{$page}";

        if (view()->exists($viewName)) {
            $data = [];

            if ($page === 'course-add') {
                $data['db_industries'] = \App\Models\Industry::where('status', 1)->get();
                $data['db_speakers'] = \App\Models\Speaker::where('status', 1)->get();
                $data['db_default_options'] = \App\Models\RegistrationOptionTemplateItem::where('template_id', 1)
                    ->where('status', 1)
                    ->get()
                    ->groupBy('category');
            }

            if ($page === 'course-list') {
                $dbCourses = \App\Models\Course::with(['industry', 'speaker'])
                    ->orderByDesc('event_date')
                    ->orderByDesc('event_time')
                    ->get();
                $webinars = [];
                foreach ($dbCourses as $course) {
                    $webinars[] = [
                        'id' => $course->id,
                        'title' => $course->title,
                        'industries' => $course->industry->name ?? 'Uncategorized',
                        'speaker' => $course->speaker->name ?? 'Guest Expert',
                        'date' => $course->event_date ? $course->event_date->format('Y-m-d') : 'Flexible',
                        'time' => $course->event_time ?? 'TBA',
                    ];
                }
                $data['webinars'] = $webinars;
                $data['db_industries'] = \App\Models\Industry::where('status', 1)->get();
                $data['db_speakers'] = \App\Models\Speaker::where('status', 1)->get();
            }

            if ($page === 'speaker') {
                $dbSpeakers = \App\Models\Speaker::all();
                $speakers = [];
                foreach ($dbSpeakers as $sp) {
                    $speakers[] = [
                        'id' => $sp->id,
                        'name' => $sp->name,
                        'email' => $sp->email ?? 'N/A',
                        'phone' => $sp->phone ?? 'N/A',
                        'designation' => $sp->designation ?? 'Expert Speaker',
                        'bio' => $sp->bio ?? '',
                        'image' => $sp->image ?? '',
                        'status' => (int)$sp->status,
                    ];
                }
                $data['speakers'] = $speakers;
            }

            if ($page === 'customers') {
                $dbCustomers = \App\Models\User::where('role', 'customer')->get();
                $customers = [];
                foreach ($dbCustomers as $c) {
                    $customers[] = [
                        'id' => $c->id,
                        'name' => $c->name,
                        'email' => $c->email,
                        'phone' => $c->phone ?? 'N/A',
                    ];
                }
                $data['customers'] = $customers;
            }

            if ($page === 'order-list') {
                $dbOrders = \App\Models\Order::with('items')->get();
                $orders = [];
                foreach ($dbOrders as $o) {
                    $firstItem = $o->items->first();
                    $orders[] = [
                        'id' => $o->id,
                        'order_id' => $o->order_number,
                        'title' => $firstItem ? $firstItem->title : 'CEU Webinar Order',
                        'selling_options' => $firstItem ? ($firstItem->description ?? 'Standard Registration') : 'N/A',
                        'amount' => (float)$o->grand_total,
                        'trans_date' => $o->created_at->format('Y-m-d H:i:s'),
                        'payment_status' => $o->payment_status === 'paid' ? 'completed' : 'Incomplete',
                    ];
                }
                $data['orders'] = $orders;
            }

            if ($page === 'coupons-list') {
                $dbCoupons = \App\Models\Coupon::all();
                $coupons = [];
                foreach ($dbCoupons as $cp) {
                    $coupons[] = [
                        'id' => $cp->id,
                        'coupon_code' => $cp->code,
                        'discount' => $cp->discount_type === 'percentage' ? ($cp->discount_value . '%') : ('$' . number_format($cp->discount_value, 2)),
                        'coupons_limit' => $cp->max_uses ?? 'Unlimited',
                        'used_count' => $cp->used_count,
                        'valid_until' => $cp->valid_until ? $cp->valid_until->format('M d, Y') : 'No expiry',
                        'status' => $cp->status,
                    ];
                }
                $data['coupons'] = $coupons;
            }

            if ($page === 'faq-categorie-list') {
                $dbFaqs = \App\Models\Faq::with('category')->get();
                $faqs = [];
                foreach ($dbFaqs as $fq) {
                    $faqs[] = [
                        'id' => $fq->id,
                        'category' => $fq->category->name ?? 'General',
                        'question' => $fq->question,
                        'answer' => $fq->answer,
                        'status' => $fq->status,
                    ];
                }
                $data['faqs'] = $faqs;
            }

            if ($page === 'contact') {
                $dbContacts = \App\Models\ContactEnquiry::all();
                $contacts = [];
                foreach ($dbContacts as $c) {
                    $contacts[] = [
                        'id' => $c->id,
                        'name' => $c->name,
                        'email' => $c->email,
                        'subject' => $c->subject ?? 'General Enquiry',
                        'message' => $c->message,
                    ];
                }
                $data['contacts'] = $contacts;
            }

            if ($page === 'smtp-settings') {
                $data['smtp'] = \App\Models\MailSetting::firstOrNew(['is_default' => 1]);
            }

            if ($page === 'payment-settings') {
                $data['gateways'] = \App\Models\PaymentGateway::with('settings')->get();
            }

            if ($page === 'industries') {
                $data['industries'] = \App\Models\Industry::all();
            }

            if ($page === 'selling-options') {
                $data['default_options'] = \App\Models\RegistrationOptionTemplateItem::where('template_id', 1)
                    ->orderBy('sort_order')
                    ->get();
            }

            return view($viewName, $data);
        }

        abort(404, "Page {$page} not found in admin folder.");
    }

    /**
     * Store a newly created course and its custom registration options
     */
    public function storeCourse(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:500',
            'slug' => 'required|string|unique:courses,slug',
            'description' => 'required|string',
            'certificate_text' => 'nullable|string',
            'industries' => 'required|exists:industries,id',
            'speaker' => 'required|exists:speakers,id',
            'price' => 'nullable|numeric',
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required|integer',
            'status' => 'required'
        ]);

        $basePrice = $request->input('price', 185.00);

        // Create the new course in courses table
        $course = \App\Models\Course::create([
            'industry_id' => $request->input('industries'),
            'speaker_id' => $request->input('speaker'),
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
            'short_description' => \Illuminate\Support\Str::limit(strip_tags($request->input('description')), 200),
            'certificate_text' => $request->input('certificate_text') ?: 'Successfully completed CEU credits certification requirements.',
            'thumbnail' => 'ceutrainers.webp',
            'event_date' => $request->input('date'),
            'event_time' => $request->input('time'),
            'duration_minutes' => $request->input('duration', 60),
            'single_sale_enabled' => 1,
            'subscription_enabled' => 1,
            'default_price' => $basePrice,
            'currency' => 'USD',
            'status' => $request->input('status') === '1' ? 'published' : 'draft',
        ]);

        // Copy pricing options from templates
        $optionsInput = $request->input('options', []);
        $templateItems = \App\Models\RegistrationOptionTemplateItem::where('template_id', 1)->get();
        
        foreach ($templateItems as $item) {
            $optPrice = $item->price;
            // The input key is options[category][label]
            if (isset($optionsInput[$item->category][$item->label])) {
                $optPrice = (float)$optionsInput[$item->category][$item->label];
            }

            \App\Models\CoursePricing::create([
                'course_id' => $course->id,
                'template_item_id' => $item->id,
                'category' => $item->category,
                'label' => $item->label,
                'attendees' => $item->attendees,
                'price' => $optPrice,
                'compare_at_price' => $item->compare_at_price ? ($basePrice * 2.0) : null,
                'currency' => 'USD',
                'description' => $item->description,
                'sort_order' => $item->sort_order,
                'status' => 1,
            ]);
        }

        return redirect()->route('admin.page', 'course-list')->with('success', 'Course added successfully with dynamic registration options!');
    }

    /**
     * Delete an existing course
     */
    public function deleteCourse($id)
    {
        $course = \App\Models\Course::findOrFail($id);
        
        // Delete related pricing records
        \App\Models\CoursePricing::where('course_id', $id)->delete();
        
        // Delete the course
        $course->delete();

        return redirect()->route('admin.page', 'course-list')->with('success', 'Course deleted successfully!');
    }

    /**
     * Display full customer profile, orders, subscriptions, and access details.
     */
    public function showCustomer($id)
    {
        $customer = \App\Models\User::where('role', 'customer')
            ->with([
                'addresses',
                'orders.items.course',
                'orders.items.subscriptionPlan',
                'orders.transactions',
                'subscriptions.plan',
                'subscriptions.order',
                'courseAccesses.course',
                'courseAccesses.order',
            ])
            ->withCount(['orders', 'subscriptions', 'courseAccesses'])
            ->withSum(['orders' => fn($q) => $q->where('payment_status', 'paid')], 'grand_total')
            ->findOrFail($id);

        $activeSubscriptions = $customer->subscriptions
            ->filter(function ($subscription) {
                return in_array($subscription->status, ['active', 'trialing']);
            });

        $latestOrder = $customer->orders->sortByDesc('created_at')->first();

        return view('admin.customer-show', [
            'customer' => $customer,
            'activeSubscriptions' => $activeSubscriptions,
            'latestOrder' => $latestOrder,
        ]);
    }

    /**
     * Display full order details for administrators.
     */
    public function showOrder($id)
    {
        $order = \App\Models\Order::with([
            'user',
            'coupon',
            'items.course',
            'items.coursePricing',
            'items.subscriptionPlan',
            'attendees',
            'transactions.gateway',
        ])->findOrFail($id);

        $subscription = \App\Models\UserSubscription::with('plan')
            ->where('order_id', $order->id)
            ->latest()
            ->first();

        $courseAccesses = \App\Models\UserCourseAccess::with('course')
            ->where('order_id', $order->id)
            ->get();

        return view('admin.order-show', compact('order', 'subscription', 'courseAccesses'));
    }

    /**
     * Download order as PDF
     */
    public function downloadOrderPDF($id)
    {
        $order = \App\Models\Order::with([
            'user',
            'coupon',
            'items.course',
            'items.coursePricing',
            'items.subscriptionPlan',
            'attendees',
            'transactions.gateway',
        ])->findOrFail($id);

        $subscription = \App\Models\UserSubscription::with('plan')
            ->where('order_id', $order->id)
            ->latest()
            ->first();

        $courseAccesses = \App\Models\UserCourseAccess::with('course')
            ->where('order_id', $order->id)
            ->get();

        $pdf = \PDF::loadView('admin.order-pdf', compact('order', 'subscription', 'courseAccesses'));
        return $pdf->download('Order-' . $order->order_number . '.pdf');
    }

    /**
     * Campaign Report
     */
    public function campaignReport(Request $request)
    {
        // Parse date inputs
        if ($request->filled('from_date')) {
            $fromDate = Carbon::parse($request->input('from_date'))->startOfDay();
        } else {
            $fromDate = Carbon::now()->subDays(30)->startOfDay();
        }

        if ($request->filled('to_date')) {
            $toDate = Carbon::parse($request->input('to_date'))->endOfDay();
        } else {
            $toDate = Carbon::now()->endOfDay();
        }

        $onlyCompleted = $request->has('only_completed') || $request->input('only_completed') == '1';

        // Query orders in that date range
        $query = \App\Models\Order::with(['user'])
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate);

        // Fetch all orders matching the date range
        $allOrders = $query->orderBy('created_at', 'desc')->get();

        $totalOrdersCount = 0;
        $paidOrdersCount = 0;
        $paidRevenue = 0.0;
        
        $utmGroups = [];
        $ordersData = [];

        foreach ($allOrders as $order) {
            $notes = json_decode($order->notes, true) ?: [];
            $address = $notes['address_snapshot'] ?? [];
            $utm = $notes['utm_data'] ?? [];

            $source = !empty($utm['utm_source']) ? $utm['utm_source'] : 'Direct / Unknown';
            $medium = !empty($utm['utm_medium']) ? $utm['utm_medium'] : 'Unknown';
            $campaign = !empty($utm['utm_campaign']) ? $utm['utm_campaign'] : 'Not Set';

            $isPaid = $order->payment_status === 'paid';
            $amount = (float)$order->grand_total;

            // Apply "Only Completed Orders" filter for counts & grouping
            if ($onlyCompleted && !$isPaid) {
                continue;
            }

            $totalOrdersCount++;
            if ($isPaid) {
                $paidOrdersCount++;
                $paidRevenue += $amount;
            }

            // Grouping key for campaign stats
            $key = $source . '|' . $medium . '|' . $campaign;
            if (!isset($utmGroups[$key])) {
                $utmGroups[$key] = [
                    'source' => $source,
                    'medium' => $medium,
                    'campaign' => $campaign,
                    'orders' => 0,
                    'paid_orders' => 0,
                    'revenue' => 0.0,
                ];
            }

            $utmGroups[$key]['orders']++;
            if ($isPaid) {
                $utmGroups[$key]['paid_orders']++;
                $utmGroups[$key]['revenue'] += $amount;
            }

            // Order record for list
            $ordersData[] = [
                'order_number' => $order->order_number,
                'name' => $address['name'] ?? ($order->user->name ?? 'N/A'),
                'status' => $order->payment_status,
                'amount' => $amount,
                'source' => $source,
                'medium' => $medium,
                'campaign' => $campaign,
                'date' => $order->created_at->format('Y-m-d H:i:s'),
            ];
        }

        // Compute conversion rate for each campaign
        foreach ($utmGroups as &$group) {
            $group['conversion_rate'] = $group['orders'] > 0
                ? ($group['paid_orders'] / $group['orders']) * 100
                : 0.0;
        }
        unset($group);

        // Convert to array
        $campaignsList = array_values($utmGroups);

        // Export CSV if requested
        if ($request->input('export') === 'csv') {
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="utm_campaign_report_' . now()->format('Ymd_His') . '.csv"',
            ];

            $callback = function() use ($ordersData) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['Order ID', 'Name', 'Status', 'Amount', 'Source', 'Medium', 'Campaign', 'Date']);

                foreach ($ordersData as $row) {
                    fputcsv($file, [
                        $row['order_number'],
                        $row['name'],
                        ucfirst($row['status']),
                        '$' . number_format($row['amount'], 2),
                        $row['source'],
                        $row['medium'],
                        $row['campaign'],
                        $row['date'],
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        // Sort Top Performing Campaigns by revenue descending
        $performingCampaigns = $campaignsList;
        usort($performingCampaigns, function($a, $b) {
            if ($b['revenue'] != $a['revenue']) {
                return $b['revenue'] <=> $a['revenue'];
            }
            return $b['paid_orders'] <=> $a['paid_orders'];
        });
        $topPerforming = array_slice($performingCampaigns, 0, 5);

        // Sort Top Losing Campaigns by conversion rate ascending
        $losingCampaigns = $campaignsList;
        usort($losingCampaigns, function($a, $b) {
            if ($a['conversion_rate'] != $b['conversion_rate']) {
                return $a['conversion_rate'] <=> $b['conversion_rate'];
            }
            return $b['orders'] <=> $a['orders'];
        });
        $topLosing = array_slice($losingCampaigns, 0, 5);

        $data = [
            'total_orders' => $totalOrdersCount,
            'paid_orders' => $paidOrdersCount,
            'paid_revenue' => $paidRevenue,
            'top_performing' => $topPerforming,
            'top_losing' => $topLosing,
            'utm_summary' => $campaignsList,
            'orders_data' => $ordersData,
            'from_date' => $fromDate->format('Y-m-d'),
            'to_date' => $toDate->format('Y-m-d'),
            'only_completed' => $onlyCompleted,
        ];

        return view('admin.campaign-report', $data);
    }

    /**
     * Update an existing course
     */
    public function updateCourse(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:500',
            'slug' => 'required|string|unique:courses,slug,' . $id,
            'description' => 'required|string',
            'certificate_text' => 'nullable|string',
            'industries' => 'required|exists:industries,id',
            'speaker' => 'required|exists:speakers,id',
            'price' => 'nullable|numeric',
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required|integer',
            'status' => 'required',
            'course_thumbail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $basePrice = $request->input('price', 185.00);

        $course = \App\Models\Course::findOrFail($id);
        $courseData = [
            'industry_id' => $request->input('industries'),
            'speaker_id' => $request->input('speaker'),
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
            'certificate_text' => $request->input('certificate_text') ?: 'Successfully completed CEU credits certification requirements.',
            'short_description' => \Illuminate\Support\Str::limit(strip_tags($request->input('description')), 200),
            'event_date' => $request->input('date'),
            'event_time' => $request->input('time'),
            'duration_minutes' => $request->input('duration', 60),
            'default_price' => $basePrice,
            'status' => $request->input('status') === '1' ? 'published' : 'draft',
        ];

        if ($request->hasFile('course_thumbail')) {
            $thumbnail = $request->file('course_thumbail');
            $thumbnailName = \Illuminate\Support\Str::slug(pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME))
                . '-' . time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move(public_path('ceuadmin-assets/assets/images/course'), $thumbnailName);
            $courseData['thumbnail'] = $thumbnailName;
        }

        $course->update($courseData);

        // Update pricing options
        $optionsInput = $request->input('options', []);
        $templateItems = \App\Models\RegistrationOptionTemplateItem::where('template_id', 1)->get();
        
        foreach ($templateItems as $item) {
            $optPrice = $item->price;
            // The input key is options[category][label]
            if (isset($optionsInput[$item->category][$item->label])) {
                $optPrice = (float)$optionsInput[$item->category][$item->label];
            }

            \App\Models\CoursePricing::updateOrCreate(
                [
                    'course_id' => $course->id,
                    'template_item_id' => $item->id,
                ],
                [
                    'category' => $item->category,
                    'label' => $item->label,
                    'price' => $optPrice,
                    'description' => $item->description,
                    'sort_order' => $item->sort_order,
                    'status' => 1,
                ]
            );
        }

        return redirect()->route('admin.page', 'course-list')->with('success', 'Course updated successfully!');
    }

    /**
     * Save dynamic SMTP mail settings
     */
    public function saveSmtp(Request $request)
    {
        $request->validate([
            'mailer' => 'required|string',
            'host' => 'required|string',
            'port' => 'required|integer',
            'username' => 'required|string',
            'from_address' => 'required|email',
            'from_name' => 'required|string',
        ]);

        $smtp = \App\Models\MailSetting::firstOrNew(['is_default' => 1]);
        $smtp->mailer = $request->input('mailer');
        $smtp->host = $request->input('host');
        $smtp->port = $request->input('port');
        $smtp->username = $request->input('username');
        if ($request->filled('password')) {
            $smtp->setPassword($request->input('password'));
        }
        $smtp->encryption = $request->input('encryption', 'tls');
        $smtp->from_address = $request->input('from_address');
        $smtp->from_name = $request->input('from_name');
        $smtp->status = 1;
        $smtp->save();

        return redirect()->route('admin.page', 'smtp-settings')->with('success', 'SMTP mail settings updated successfully!');
    }

    /**
     * Save payment gateway sandbox/live credentials with auto encryption
     */
    public function saveGateway(Request $request, $id)
    {
        $gateway = \App\Models\PaymentGateway::findOrFail($id);
        $previousMode = $gateway->mode;
        $previousSecret = $gateway->slug === 'stripe' ? $gateway->getSetting('secret_key') : null;
        $settings = $request->input('settings', []);

        if ($gateway->slug === 'stripe') {
            $publishableKey = trim((string) ($settings['publishable_key'] ?? ''));
            $secretKey = trim((string) ($settings['secret_key'] ?? ''));

            if ($publishableKey !== '' && !str_starts_with($publishableKey, 'pk_test_') && !str_starts_with($publishableKey, 'pk_live_')) {
                return back()->withInput()->withErrors([
                    'settings.publishable_key' => 'Stripe publishable key must start with pk_test_ or pk_live_.',
                ]);
            }

            if ($secretKey !== '' && !str_starts_with($secretKey, 'sk_test_') && !str_starts_with($secretKey, 'sk_live_')) {
                return back()->withInput()->withErrors([
                    'settings.secret_key' => 'Stripe secret key must start with sk_test_ or sk_live_. Do not use mk_ or pk_ keys here.',
                ]);
            }
        }

        $gateway->mode = $request->input('mode', 'sandbox');
        $gateway->status = (bool)$request->input('status', 1);
        $gateway->save();

        foreach ($settings as $key => $val) {
            $encrypt = in_array($key, ['secret_key', 'webhook_secret', 'client_secret']);
            
            $setting = \App\Models\PaymentGatewaySetting::firstOrNew([
                'gateway_id' => $gateway->id,
                'setting_key' => $key
            ]);
            
            // Only update secret if a value was provided
            if ($encrypt && empty($val)) {
                continue;
            }
            
            $setting->setValue($val, $encrypt);
            $setting->save();
        }

        if ($gateway->slug === 'stripe') {
            $currentSecret = $gateway->getSetting('secret_key');
            if ($previousMode !== $gateway->mode || $previousSecret !== $currentSecret) {
                \App\Models\SubscriptionPlan::query()->update(['stripe_price_id' => null]);
            }
        }

        return redirect()->route('admin.page', 'payment-settings')->with('success', $gateway->name . ' Gateway settings updated successfully!');
    }

    /**
     * Store a newly created Industry
     */
    public function storeIndustry(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'required|string|unique:industries,slug',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'status' => 'required|boolean',
        ]);

        $imageName = 'default-industry.png';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME))
                . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/category'), $imageName);
        }

        \App\Models\Industry::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'image' => $imageName,
            'description' => $request->input('name') . ' continuing education courses.',
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.page', 'Industries')->with('success', 'Industry added successfully!');
    }

    /**
     * Delete an Industry
     */
    public function deleteIndustry($id)
    {
        $industry = \App\Models\Industry::findOrFail($id);
        $industry->delete();

        return redirect()->route('admin.page', 'Industries')->with('success', 'Industry deleted successfully!');
    }

    /**
     * Store a newly created default registration option template item
     */
    public function storeDefaultOption(Request $request)
    {
        $request->validate([
            'category' => 'required|in:live,recording,combo,super_saver,custom',
            'label' => 'required|string|max:200',
            'attendees' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'sort_order' => 'required|integer',
        ]);

        \App\Models\RegistrationOptionTemplateItem::create([
            'template_id' => 1,
            'category' => $request->input('category'),
            'label' => $request->input('label'),
            'attendees' => $request->input('attendees'),
            'price' => $request->input('price'),
            'compare_at_price' => $request->input('compare_at_price'),
            'description' => $request->input('description'),
            'sort_order' => $request->input('sort_order'),
            'status' => 1,
        ]);

        return redirect()->route('admin.page', 'Selling-options')->with('success', 'Default registration option added successfully!');
    }

    /**
     * Delete a default registration option template item
     */
    public function deleteDefaultOption($id)
    {
        $option = \App\Models\RegistrationOptionTemplateItem::findOrFail($id);
        $option->delete();

        return redirect()->route('admin.page', 'Selling-options')->with('success', 'Default registration option deleted successfully!');
    }

    /**
     * Update a default registration option template item
     */
    public function updateDefaultOption(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|in:live,recording,combo,super_saver,custom',
            'label' => 'required|string|max:200',
            'attendees' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'sort_order' => 'required|integer',
        ]);

        $option = \App\Models\RegistrationOptionTemplateItem::findOrFail($id);
        $option->update([
            'category' => $request->input('category'),
            'label' => $request->input('label'),
            'attendees' => $request->input('attendees'),
            'price' => $request->input('price'),
            'compare_at_price' => $request->input('compare_at_price'),
            'description' => $request->input('description'),
            'sort_order' => $request->input('sort_order'),
        ]);

        return redirect()->route('admin.page', 'Selling-options')->with('success', 'Default registration option updated successfully!');
    }

    /**
     * Update an existing Industry
     */
    public function updateIndustry(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'required|string|unique:industries,slug,' . $id,
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'status' => 'required|boolean',
        ]);

        $industry = \App\Models\Industry::findOrFail($id);

        $industryData = [
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'status' => $request->input('status'),
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME))
                . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/category'), $imageName);
            $industryData['image'] = $imageName;
        }

        $industry->update($industryData);

        return redirect()->route('admin.page', 'Industries')->with('success', 'Industry updated successfully!');
    }

    /**
     * Store a newly created speaker.
     */
    public function storeSpeaker(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:180',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:40',
            'designation' => 'nullable|string|max:180',
            'bio' => 'nullable|string',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $speakerData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'designation' => $request->input('designation'),
            'bio' => $request->input('bio'),
            'status' => $request->input('status'),
            'is_verified' => 1,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME))
                . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('ceuadmin-assets/assets/images/speaker'), $imageName);
            $speakerData['image'] = $imageName;
        }

        \App\Models\Speaker::create($speakerData);

        return redirect()->route('admin.page', 'speaker')->with('success', 'Speaker added successfully!');
    }

    /**
     * Update an existing speaker.
     */
    public function updateSpeaker(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:180',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:40',
            'designation' => 'nullable|string|max:180',
            'bio' => 'nullable|string',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $speaker = \App\Models\Speaker::findOrFail($id);
        $speakerData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'designation' => $request->input('designation'),
            'bio' => $request->input('bio'),
            'status' => $request->input('status'),
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = \Illuminate\Support\Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME))
                . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('ceuadmin-assets/assets/images/speaker'), $imageName);
            $speakerData['image'] = $imageName;
        }

        $speaker->update($speakerData);

        return redirect()->route('admin.page', 'speaker')->with('success', 'Speaker updated successfully!');
    }

    /**
     * Store a FAQ category and optional first FAQ question.
     */
    public function storeFaqCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'question' => 'nullable|string',
            'answer' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|boolean',
        ]);

        $category = \App\Models\FaqCategory::create([
            'name' => $request->input('name'),
            'slug' => \Illuminate\Support\Str::slug($request->input('name')),
            'status' => $request->boolean('status'),
            'sort_order' => $request->input('sort_order', 0),
        ]);

        if ($request->filled('question') && $request->filled('answer')) {
            \App\Models\Faq::create([
                'category_id' => $category->id,
                'question' => $request->input('question'),
                'answer' => $request->input('answer'),
                'status' => $request->boolean('status'),
                'sort_order' => $request->input('sort_order', 0),
            ]);
        }

        return redirect()->route('admin.page', 'faq-categorie-list')->with('success', 'FAQ category added successfully!');
    }

    public function editFaq($id)
    {
        $faq = \App\Models\Faq::with('category')->findOrFail($id);
        $categories = \App\Models\FaqCategory::orderBy('sort_order')->orderBy('name')->get();

        return view('admin.faq-edit', [
            'faq' => $faq,
            'categories' => $categories,
        ]);
    }

    public function updateFaq(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'nullable|exists:faq_categories,id',
            'question' => 'required|string',
            'answer' => 'required|string',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|boolean',
        ]);

        $faq = \App\Models\Faq::findOrFail($id);
        $faq->update([
            'category_id' => $request->input('category_id'),
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
            'sort_order' => $request->input('sort_order', 0),
            'status' => $request->boolean('status'),
        ]);

        return redirect()->route('admin.page', 'faq-categorie-list')->with('success', 'FAQ updated successfully!');
    }

    public function addCoupon()
    {
        return view('admin.coupon-form', [
            'coupon' => new \App\Models\Coupon(),
            'mode' => 'add',
        ]);
    }

    public function storeCoupon(Request $request)
    {
        $data = $this->validateCoupon($request);
        $data['code'] = strtoupper($data['code']);
        $data['used_count'] = 0;

        \App\Models\Coupon::create($data);

        return redirect()->route('admin.page', 'coupons-list')->with('success', 'Coupon added successfully!');
    }

    public function editCoupon($id)
    {
        return view('admin.coupon-form', [
            'coupon' => \App\Models\Coupon::findOrFail($id),
            'mode' => 'edit',
        ]);
    }

    public function updateCoupon(Request $request, $id)
    {
        $coupon = \App\Models\Coupon::findOrFail($id);
        $data = $this->validateCoupon($request, $coupon->id);
        $data['code'] = strtoupper($data['code']);

        $coupon->update($data);

        return redirect()->route('admin.page', 'coupons-list')->with('success', 'Coupon updated successfully!');
    }

    private function validateCoupon(Request $request, $ignoreId = null)
    {
        $uniqueRule = 'unique:coupons,code';
        if ($ignoreId) {
            $uniqueRule .= ',' . $ignoreId;
        }

        return $request->validate([
            'code' => ['required', 'string', 'max:80', $uniqueRule],
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'status' => 'required|boolean',
        ]);
    }

    public function testimonials()
    {
        $testimonials = \App\Models\Testimonial::orderBy('sort_order')->latest()->get();

        return view('admin.testimonials', compact('testimonials'));
    }

    public function addTestimonial()
    {
        return view('admin.testimonial-form', [
            'testimonial' => new \App\Models\Testimonial(),
            'mode' => 'add',
        ]);
    }

    public function storeTestimonial(Request $request)
    {
        \App\Models\Testimonial::create($this->validateTestimonial($request));

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial added successfully!');
    }

    public function editTestimonial($id)
    {
        return view('admin.testimonial-form', [
            'testimonial' => \App\Models\Testimonial::findOrFail($id),
            'mode' => 'edit',
        ]);
    }

    public function updateTestimonial(Request $request, $id)
    {
        $testimonial = \App\Models\Testimonial::findOrFail($id);
        $testimonial->update($this->validateTestimonial($request));

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully!');
    }

    private function validateTestimonial(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:180',
            'designation' => 'nullable|string|max:180',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|boolean',
        ]);
    }

    public function subscriptionPlans()
    {
        $plans = \App\Models\SubscriptionPlan::withCount(['features', 'courses', 'industries'])
            ->orderBy('sort_order')
            ->get();

        return view('admin.subscription-plans', compact('plans'));
    }

    public function addSubscriptionPlan()
    {
        return view('admin.subscription-plan-form', $this->subscriptionPlanFormData(new \App\Models\SubscriptionPlan(), 'add'));
    }

    public function storeSubscriptionPlan(Request $request)
    {
        $data = $this->validateSubscriptionPlan($request);
        $data['slug'] = $data['slug'] ?: \Illuminate\Support\Str::slug($data['name']);

        $plan = \App\Models\SubscriptionPlan::create($data);
        $this->syncSubscriptionPlanRelations($plan, $request);

        return redirect()->route('admin.subscription-plans.index')->with('success', 'Subscription plan added successfully!');
    }

    public function editSubscriptionPlan($id)
    {
        $plan = \App\Models\SubscriptionPlan::with(['features', 'courses', 'industries'])->findOrFail($id);

        return view('admin.subscription-plan-form', $this->subscriptionPlanFormData($plan, 'edit'));
    }

    public function updateSubscriptionPlan(Request $request, $id)
    {
        $plan = \App\Models\SubscriptionPlan::findOrFail($id);
        $data = $this->validateSubscriptionPlan($request, $plan->id);
        $data['slug'] = $data['slug'] ?: \Illuminate\Support\Str::slug($data['name']);
        $gatewayFieldsChanged = $this->subscriptionGatewayFieldsChanged($plan, $data);

        $plan->update($data);
        if ($gatewayFieldsChanged) {
            $plan->forceFill([
                'stripe_price_id' => null,
                'paypal_product_id' => null,
                'paypal_plan_id' => null,
            ])->save();
        }

        $this->syncSubscriptionPlanRelations($plan, $request);

        return redirect()->route('admin.subscription-plans.index')->with('success', 'Subscription plan updated successfully!');
    }

    private function subscriptionPlanFormData($plan, $mode)
    {
        return [
            'plan' => $plan,
            'mode' => $mode,
            'features' => \App\Models\SubscriptionFeature::where('status', 1)->orderBy('sort_order')->get(),
            'courses' => \App\Models\Course::orderBy('title')->get(),
            'industries' => \App\Models\Industry::where('status', 1)->orderBy('name')->get(),
            'featureValues' => $plan->exists ? $plan->features->pluck('pivot.value', 'id')->toArray() : [],
            'selectedCourses' => $plan->exists ? $plan->courses->pluck('id')->toArray() : [],
            'selectedIndustries' => $plan->exists ? $plan->industries->pluck('id')->toArray() : [],
        ];
    }

    private function validateSubscriptionPlan(Request $request, $ignoreId = null)
    {
        $uniqueSlug = 'unique:subscription_plans,slug';
        if ($ignoreId) {
            $uniqueSlug .= ',' . $ignoreId;
        }

        $data = $request->validate([
            'name' => 'required|string|max:180',
            'slug' => ['nullable', 'string', 'max:200', $uniqueSlug],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'duration_days' => 'required|integer|min:1',
            'free_extra_days' => 'nullable|integer|min:0',
            'max_course_access' => 'nullable|integer|min:1',
            'access_all_live_webinars' => 'nullable|boolean',
            'access_all_recordings' => 'nullable|boolean',
            'access_all_transcripts' => 'nullable|boolean',
            'priority_support' => 'nullable|boolean',
            'is_popular' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive,archived',
        ]);

        foreach (['access_all_live_webinars', 'access_all_recordings', 'access_all_transcripts', 'priority_support', 'is_popular'] as $field) {
            $data[$field] = $request->boolean($field);
        }

        $data['free_extra_days'] = $data['free_extra_days'] ?? 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }

    private function subscriptionGatewayFieldsChanged($plan, array $data)
    {
        foreach (['name', 'description', 'price', 'currency', 'duration_days'] as $field) {
            if ((string) ($plan->{$field} ?? '') !== (string) ($data[$field] ?? '')) {
                return true;
            }
        }

        return false;
    }

    private function syncSubscriptionPlanRelations($plan, Request $request)
    {
        $featureValues = [];
        foreach ($request->input('features', []) as $featureId => $value) {
            $featureValues[$featureId] = ['value' => $value ? '1' : '0'];
        }
        $plan->features()->sync($featureValues);

        $plan->industries()->sync($request->input('industries', []));

        \Illuminate\Support\Facades\DB::table('subscription_plan_courses')
            ->where('plan_id', $plan->id)
            ->delete();

        foreach ($request->input('courses', []) as $courseId) {
            \Illuminate\Support\Facades\DB::table('subscription_plan_courses')->insert([
                'plan_id' => $plan->id,
                'course_id' => $courseId,
                'access_type' => 'full',
                'created_at' => now(),
            ]);
        }
    }

    /**
     * Get course data for AJAX requests
     */
    public function getCourseData($id)
    {
        $course = \App\Models\Course::findOrFail($id);
        
        return response()->json([
            'id' => $course->id,
            'title' => $course->title,
            'slug' => $course->slug,
            'description' => $course->description,
            'industry_id' => $course->industry_id,
            'speaker_id' => $course->speaker_id,
            'event_date' => $course->event_date ? $course->event_date->format('Y-m-d') : '',
            'event_time' => $course->event_time ?? '',
            'duration_minutes' => $course->duration_minutes ?? 60,
            'default_price' => $course->default_price ?? 185.00,
            'status' => $course->status,
        ]);
    }

    /**
     * Show the edit course form
     */
    public function showEditCourse($id)
    {
        $course = \App\Models\Course::findOrFail($id);
        
        $data = [
            'course' => $course,
            'db_industries' => \App\Models\Industry::where('status', 1)->get(),
            'db_speakers' => \App\Models\Speaker::where('status', 1)->get(),
            'db_default_options' => \App\Models\RegistrationOptionTemplateItem::where('template_id', 1)
                ->where('status', 1)
                ->get()
                ->groupBy('category'),
        ];

        // Get current pricing for this course
        $coursePricingModels = \App\Models\CoursePricing::where('course_id', $id)->get();
        $coursePricing = [];
        foreach ($coursePricingModels as $pricing) {
            $coursePricing[$pricing->template_item_id] = $pricing->price;
        }
        $data['coursePricing'] = $coursePricing;

        return view('admin.course-edit', $data);
    }
}
