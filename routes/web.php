<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebinarController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Public Front Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');
Route::get('/terms-condition', [HomeController::class, 'termsCondition'])->name('terms-condition');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/orders/{id}/invoice', [DashboardController::class, 'showInvoice'])->name('dashboard.order.invoice');
Route::post('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
Route::post('/dashboard/address', [DashboardController::class, 'updateAddress'])->name('dashboard.address.update');
Route::post('/dashboard/password', [DashboardController::class, 'updatePassword'])->name('dashboard.password.update');
Route::get('/webinar', [WebinarController::class, 'index'])->name('webinar.index');
Route::get('/course-details/{slug}', [CourseController::class, 'show'])->name('course.show');

// Speakers
Route::get('/speakers', [SpeakerController::class, 'index'])->name('speakers.index');
Route::get('/speakers/{speaker}', [SpeakerController::class, 'show'])->name('speakers.show');
Route::get('/becomeSpeaker', [SpeakerController::class, 'become'])->name('speakers.become');

// Subscription & FAQs & Contact
Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.index');
Route::post('/subscription/add/{id}', [SubscriptionController::class, 'addToCart'])->name('subscription.add');
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Cart Sessions
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'showCheckout'])->name('cart.checkout');
Route::get('/checkout/check-email', [CartController::class, 'checkEmail'])->name('cart.checkout.check-email');
Route::post('/checkout/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::post('/checkout/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
Route::post('/checkout', [CartController::class, 'processCheckout'])->name('cart.checkout.process');
Route::get('/payment/stripe/success/{order}', [CartController::class, 'stripeSuccess'])->name('payment.stripe.success');
Route::get('/payment/paypal/success/{order}', [CartController::class, 'paypalSuccess'])->name('payment.paypal.success');
Route::get('/payment/cancel/{order}', [CartController::class, 'paymentCancel'])->name('payment.cancel');

// User Authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/login/send-credentials', [LoginController::class, 'sendCredentials'])->name('login.send-credentials');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

use App\Http\Controllers\Admin\AdminController;

// Admin Panel MVC Routing
Route::prefix('ceuadmin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Explicit POST handlers
    Route::post('/course-add', [AdminController::class, 'storeCourse'])->name('admin.course.store');
    Route::post('/course-delete/{id}', [AdminController::class, 'deleteCourse'])->name('admin.course.delete');
    Route::post('/course-update/{id}', [AdminController::class, 'updateCourse'])->name('admin.course.update');
    Route::get('/course-edit/{id}', [AdminController::class, 'showEditCourse'])->name('admin.course.edit');
    Route::get('/customers/{id}', [AdminController::class, 'showCustomer'])->name('admin.customer.show');
    Route::post('/smtp-settings', [AdminController::class, 'saveSmtp'])->name('admin.smtp.save');
    Route::post('/payment-settings/{id}', [AdminController::class, 'saveGateway'])->name('admin.gateway.save');
    Route::get('/orders/{id}', [AdminController::class, 'showOrder'])->name('admin.order.show');
    Route::get('/orders/{id}/pdf', [AdminController::class, 'downloadOrderPDF'])->name('admin.order.pdf');
    Route::get('/campaign-report', [AdminController::class, 'campaignReport'])->name('admin.campaign.report');
    Route::post('/industries-add', [AdminController::class, 'storeIndustry'])->name('admin.industry.store');
    Route::post('/industries-delete/{id}', [AdminController::class, 'deleteIndustry'])->name('admin.industry.delete');
    Route::post('/industries-update/{id}', [AdminController::class, 'updateIndustry'])->name('admin.industry.update');
    Route::post('/speaker-add', [AdminController::class, 'storeSpeaker'])->name('admin.speaker.store');
    Route::post('/speaker-update/{id}', [AdminController::class, 'updateSpeaker'])->name('admin.speaker.update');
    Route::post('/faq-categories-add', [AdminController::class, 'storeFaqCategory'])->name('admin.faq-category.store');
    Route::get('/faq-edit/{id}', [AdminController::class, 'editFaq'])->name('admin.faq.edit');
    Route::post('/faq-update/{id}', [AdminController::class, 'updateFaq'])->name('admin.faq.update');
    Route::get('/coupons-add', [AdminController::class, 'addCoupon'])->name('admin.coupon.add');
    Route::post('/coupons-add', [AdminController::class, 'storeCoupon'])->name('admin.coupon.store');
    Route::get('/coupons-edit/{id}', [AdminController::class, 'editCoupon'])->name('admin.coupon.edit');
    Route::post('/coupons-update/{id}', [AdminController::class, 'updateCoupon'])->name('admin.coupon.update');
    Route::get('/testimonials', [AdminController::class, 'testimonials'])->name('admin.testimonials.index');
    Route::get('/testimonials/add', [AdminController::class, 'addTestimonial'])->name('admin.testimonials.add');
    Route::post('/testimonials/add', [AdminController::class, 'storeTestimonial'])->name('admin.testimonials.store');
    Route::get('/testimonials/edit/{id}', [AdminController::class, 'editTestimonial'])->name('admin.testimonials.edit');
    Route::post('/testimonials/update/{id}', [AdminController::class, 'updateTestimonial'])->name('admin.testimonials.update');
    Route::get('/subscription-plans', [AdminController::class, 'subscriptionPlans'])->name('admin.subscription-plans.index');
    Route::get('/subscription-plans/add', [AdminController::class, 'addSubscriptionPlan'])->name('admin.subscription-plans.add');
    Route::post('/subscription-plans/add', [AdminController::class, 'storeSubscriptionPlan'])->name('admin.subscription-plans.store');
    Route::get('/subscription-plans/edit/{id}', [AdminController::class, 'editSubscriptionPlan'])->name('admin.subscription-plans.edit');
    Route::post('/subscription-plans/update/{id}', [AdminController::class, 'updateSubscriptionPlan'])->name('admin.subscription-plans.update');
    Route::post('/selling-options-add', [AdminController::class, 'storeDefaultOption'])->name('admin.selling-option.store');
    Route::post('/selling-options-delete/{id}', [AdminController::class, 'deleteDefaultOption'])->name('admin.selling-option.delete');
    Route::post('/selling-options-update/{id}', [AdminController::class, 'updateDefaultOption'])->name('admin.selling-option.update');
    
    Route::get('/{page}', [AdminController::class, 'renderPage'])->name('admin.page');
});

// API endpoints for admin
Route::get('/api/course/{id}', [AdminController::class, 'getCourseData']);
