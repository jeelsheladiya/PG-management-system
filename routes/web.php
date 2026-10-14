<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

// Admin
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\AdminRoomAllocationController;
use App\Http\Controllers\AdminStaffController;
use App\Http\Controllers\AdminWorkAllocationController;
use App\Http\Controllers\AdminComplainController;
use App\Http\Controllers\AdminNoticeController;
use App\Http\Controllers\AdminAmenityController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminRoomApprovalController;
use App\Http\Controllers\AdminRoomPricingController;

// Staff
use App\Http\Controllers\StaffAuthController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\StaffWorkController;
use App\Http\Controllers\StaffComplaintController;
use App\Http\Controllers\StaffProfileController;

// Member
use App\Http\Controllers\MemberAuthController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\MemberComplainController;
use App\Http\Controllers\MemberRoomController;
use App\Http\Controllers\MemberLeaveController;
use App\Http\Controllers\MemberNoticeController;
use App\Http\Controllers\MemberProfileController;
use App\Http\Controllers\MemberPaymentController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PendingPaymentController;

//visiter
use App\Http\Controllers\PageController;

use App\Http\Controllers\RoomController;

use App\Http\Controllers\ContactController;

Route::get('/registration', [RegistrationController::class, 'registration'])->name('registration');

Route::post('/registration', [RegistrationController::class, 'registration_process'])->name('registration.process');

Route::get('/verify-otp', [RegistrationController::class, 'verify_page'])->name('otp.verify');
Route::post('/verify-otp', [RegistrationController::class, 'verify_process'])->name('otp.verify.process');

/*
|--------------------------------------------------------------------------
| Common
|--------------------------------------------------------------------------
*/

//Route::get('/', fn() => view('welcome'));

/*
|--------------------------------------------------------------------------
| ADMIN AUTH (Guest)
|--------------------------------------------------------------------------
*/

Route::middleware('adminguest')->group(function () {
    Route::get('/admin', fn() => view('admin.login'));
    Route::get('/admin/login', fn() => view('admin.login'));
    Route::post('/admin/login', [AdminAuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| ADMIN PANEL (Protected)
|--------------------------------------------------------------------------
*/

Route::middleware('adminauth')->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);

    // Rooms
    Route::get('/rooms', [AdminRoomController::class, 'index']);
    Route::get('/rooms/create', [AdminRoomController::class, 'create']);
    Route::post('/rooms', [AdminRoomController::class, 'store']);
    Route::get('/rooms/{id}/edit', [AdminRoomController::class, 'edit']);
    Route::match(['post', 'put'], '/rooms/{id}/update', [AdminRoomController::class, 'update']);

    // Members
    Route::get('/members', [AdminMemberController::class, 'index']);
    Route::get('/members/create', [AdminMemberController::class, 'create']);
    Route::post('/members', [AdminMemberController::class, 'store']);
    Route::get('/members/{id}', [AdminMemberController::class, 'show']);
    Route::get('/admin/view-adhaar/{filename}', [AdminMemberController::class, 'viewAdhaar'])->name('admin.view.adhaar');
    Route::get('/members/{id}/edit', [AdminMemberController::class, 'edit']);
    Route::match(['post', 'put'], '/members/{id}/update', [AdminMemberController::class, 'update']);
    Route::get('/members/{id}/history', [AdminMemberController::class, 'history']);

    // Room Allocation
    Route::get('/allocations', [AdminRoomAllocationController::class, 'index']);
    Route::get('/allocations/create', [AdminRoomAllocationController::class, 'create']);
    Route::post('/allocations', [AdminRoomAllocationController::class, 'store']);
    Route::post('/allocations/{id}/release', [AdminRoomAllocationController::class, 'release']);


    Route::post('/room-change/{id}/approve', [AdminRoomController::class, 'approveChange'])->name('admin.room-change.approve');


    // Room Change Request
    Route::get('/room-changes', [AdminRoomController::class, 'roomChangeIndex'])->name('room-changes.index');
    Route::post('/room-change/{id}/approve', [AdminRoomController::class, 'approveChange'])->name('room-changes.approve');
    Route::post('/room-change/{id}/reject', [AdminRoomController::class, 'rejectChange'])->name('room-changes.reject');

    Route::post('/room-change/{id}/approve', [AdminRoomController::class, 'approveChange'])
        ->name('admin.room-changes.approve');

    Route::post('/room-change/{id}/reject', [AdminRoomController::class, 'rejectChange'])
        ->name('admin.room-changes.reject');


    Route::post('/leave-approve/{id}', [AdminRoomApprovalController::class, 'approveLeave']);
    Route::post('/leave-reject/{id}', [AdminRoomApprovalController::class, 'rejectLeave']);

    // Pricing
    Route::get('/pricing', [AdminRoomPricingController::class, 'index']);
    Route::get('/room-pricing/create', [AdminRoomPricingController::class, 'create']);
    Route::post('/pricing', [AdminRoomPricingController::class, 'store'])->name('admin.pricing.store');

    // Payments
    Route::resource('payments', AdminPaymentController::class);
    Route::get('/members/{id}/payments', [AdminPaymentController::class, 'memberHistory']);

    // Staff
    Route::get('/staff', [AdminStaffController::class, 'index'])->name('admin.staff.index');
    Route::get('/staff/create', [AdminStaffController::class, 'create']);
    Route::post('/staff', [AdminStaffController::class, 'store']);
    Route::get('/staff/{id}', [AdminStaffController::class, 'show']);
    Route::get('/staff/{id}/edit', [AdminStaffController::class, 'edit']);
    Route::put('/staff/{id}/update', [AdminStaffController::class, 'update']);
    Route::get('/staff/{id}/delete', [AdminStaffController::class, 'destroy']);

    // Work Allocation
    Route::get('/work', [AdminWorkAllocationController::class, 'index']);
    Route::get('/work/create', [AdminWorkAllocationController::class, 'create']);
    Route::post('/work', [AdminWorkAllocationController::class, 'store']);
    Route::get('/work/{id}/edit', [AdminWorkAllocationController::class, 'edit']);
    Route::put('/work/{id}/update', [AdminWorkAllocationController::class, 'update']);
    Route::post('/work/{id}/complete', [AdminWorkAllocationController::class, 'markComplete']);
    Route::delete('/work/{id}/delete', [AdminWorkAllocationController::class, 'destroy']);


    // Complaints
    Route::get('/complaints', [AdminComplainController::class, 'index']);
    Route::get('/complaints/{id}', [AdminComplainController::class, 'show']);
    Route::post('/complaints/{id}/assign', [AdminComplainController::class, 'assign']);
    Route::post('/complaints/{id}/resolve', [AdminComplainController::class, 'resolve']);

    // Notices
    Route::get('/notices', [AdminNoticeController::class, 'index']);
    Route::get('/notices/create', [AdminNoticeController::class, 'create']);
    Route::post('/notices', [AdminNoticeController::class, 'store']);
    Route::get('/notices/{id}/edit', [AdminNoticeController::class, 'edit']);
    Route::put('/notices/{id}', [AdminNoticeController::class, 'update']);
    Route::delete('/notices/{id}', [AdminNoticeController::class, 'destroy']);

    // Amenities
    Route::get('/amenities', [AdminAmenityController::class, 'index']);
    Route::get('/amenities/create', [AdminAmenityController::class, 'create']);
    Route::post('/amenities', [AdminAmenityController::class, 'store']);
    Route::get('/amenities/{id}/edit', [AdminAmenityController::class, 'edit']);
    Route::put('/amenities/{id}', [AdminAmenityController::class, 'update']);
    Route::delete('/amenities/{id}', [AdminAmenityController::class, 'destroy']);

    // Reports
    Route::get('/reports', [AdminReportController::class, 'index']);
    Route::get('/reports/export-pdf', [AdminReportController::class, 'exportPDF'])->name('admin.reports.pdf');
});


// Admin payment at allocation
Route::prefix('admin')->middleware('adminauth')->name('admin.')->group(function () {



    // આ રીતે રૂટ હોવો જોઈએ
    Route::put('/admin/payments/{id}/update', [AdminPaymentController::class, 'update'])->name('payments.update');
    // Aa route preview dikhavva mate chhe
    Route::get('/payments/preview/{allocationId}', [AdminPaymentController::class, 'preview'])
        ->name('payments.preview');

    // Aa route final payment store karva mate chhe
    Route::post('/payments/store-final', [AdminPaymentController::class, 'store_final'])
        ->name('payments.store_final');
});
// Admin Logout
Route::get('/admin/logout', [AdminAuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| STAFF
|--------------------------------------------------------------------------
*/

Route::middleware('staff.guest')->group(function () {
    Route::get('/staff/login', [StaffAuthController::class, 'showLogin']);
    Route::post('/staff/login', [StaffAuthController::class, 'login']);
});

Route::middleware('staff.auth')->group(function () {
    Route::get('/staff/dashboard', [StaffDashboardController::class, 'index']);
    Route::get('/staff/work', [StaffWorkController::class, 'index']);
    Route::post('/staff/work/{id}/complete', [StaffWorkController::class, 'complete']);

    Route::get('/staff/complaints', [StaffComplaintController::class, 'index']);
    Route::post('/staff/complaints/{id}/resolve', [StaffComplaintController::class, 'resolve']);

    Route::get('/staff/profile', [StaffProfileController::class, 'index']);
    Route::post('/staff/profile/password', [StaffProfileController::class, 'changePassword']);
});

Route::get('/staff/logout', [StaffAuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| MEMBER
|--------------------------------------------------------------------------
*/

Route::middleware('member.guest')->group(function () {
    Route::get('/member/login', [MemberAuthController::class, 'showLogin'])->name('login');
    Route::post('/member/login', [MemberAuthController::class, 'login']);
});

Route::middleware('member.auth')->group(function () {

    // Dashboard
    Route::get('/member/dashboard', [MemberDashboardController::class, 'index']);

    // Rooms
    Route::get('/member/rooms', [MemberRoomController::class, 'index']);
    Route::get('/member/my-room', [MemberRoomController::class, 'myRoom'])->name('member.my-room');
    Route::post('/member/rooms/{room}/confirm-member', [MemberRoomController::class, 'confirmMember'])->name('rooms.confirmMember');
    // Route::get('/member/rooms/book/{room}', [MemberRoomController::class, 'bookRoom'])->name('member.rooms.book');
    Route::get('/member/room/change', [MemberRoomController::class, 'changeRoomForm'])->name('member.room.change.form');
    Route::post('/member/room/change', [MemberRoomController::class, 'storeChangeRequest'])->name('member.room.change.store');


    // Payment Flow
    Route::get('/rooms/payment/{allocation}', [MemberRoomController::class, 'paymentPage'])->name('rooms.payment.page');
    Route::post('/rooms/payment/{allocation}/preview', [MemberRoomController::class, 'paymentPreview'])->name('rooms.payment.preview');
    Route::post('/rooms/payment/{allocation}/pay', [MemberRoomController::class, 'processStripePayment'])->name('rooms.payment.pay');
    Route::post('/payment/stripe/{allocation}', [MemberRoomController::class, 'processStripePayment'])->name('payment.stripe');
    Route::get('/payment/success/{allocation}', [MemberRoomController::class, 'stripeSuccess'])->name('stripe.success');

    // Complaints
    Route::get('/member/complaints', [MemberComplainController::class, 'index']);
    Route::get('/member/complaints/create', [MemberComplainController::class, 'create']);
    Route::post('/member/complaints/store', [MemberComplainController::class, 'store']);
    Route::get('/member/complaints/{id}', [MemberComplainController::class, 'show']);

    // Leave Room
    Route::post('/member/leave-room/{allocationId}', [MemberLeaveController::class, 'checkAndLeave'])->name('member.leave-room');

    // Amenities & Notices
    Route::get('/member/amenities', [MemberRoomController::class, 'amenities']);
    Route::get('/member/notices', [MemberNoticeController::class, 'index']);

    // payment list
    Route::get('/member/payments', [MemberPaymentController::class, 'index'])->name('member.payments.index');
    Route::get('/member/payments/{id}/receipt', [MemberPaymentController::class, 'downloadReceipt'])->name('member.payments.receipt');

    // Profile
    Route::get('/member/profile', [MemberProfileController::class, 'index']);
    Route::post('/member/profile/update', [MemberProfileController::class, 'update'])->name('member.profile.update');

    // View Adhaar
    Route::get('/member/view-adhaar/{filename}', [MemberProfileController::class, 'viewAdhaar'])->name('member.view-adhaar');

});

// Member Logout
Route::get('/member/logout', [MemberAuthController::class, 'logout']);




//home
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/amenities', [PageController::class, 'amenities'])->name('amenities');
Route::get('/contact', [ContactController::class, 'contact'])->name('contactus');
Route::post('/contact-process', [ContactController::class, 'contact_msg_process'])->name('contactus_process');

Route::get('/registration', [RegistrationController::class, 'registration'])->name('registration');

Route::post('/registration', [RegistrationController::class, 'registration_process'])->name('registration.process');

// room
Route::get('/rooms', [RoomController::class, 'room'])->name('rooms');
Route::get('/room-details/{id}', [RoomController::class, 'show']);
Route::get('/room-details/{room}', [RoomController::class, 'details']);
Route::get('/member/rooms/book/{room}', [MemberRoomController::class, 'bookRoom'])->name('member.rooms.book');

// 3. Final Store Payment (POST)
Route::post('/room/payment-pay/{allocationId}', [MemberRoomController::class, 'confirmstorePayment'])->name('rooms.confirmpayment.pay');



Route::middleware(['member.auth'])->prefix('member')->group(function () {
    // 1. Date Selection Page
    Route::get('/room/payment/{allocationId}', [MemberRoomController::class, 'paymentPage'])->name('rooms.payment.page');

    // 2. Preview & Calculation (POST)
    Route::post('/room/payment-preview/{allocationId}', [MemberRoomController::class, 'paymentPreview'])->name('rooms.payment.preview');


    // Success Redirect Page
    Route::get('/my-room', [MemberRoomController::class, 'myRoom'])->name('member.my-room');
});




Route::get('/member/rooms/book/{room}', [MemberRoomController::class, 'visiterbookRoom'])->name('member.visiterrooms.book');

Route::get('/confirm-details/{room_id}', [MemberRoomController::class, 'confirmDetails'])->name('member.confirm.details');

// 2. calculation
Route::any('/room/payment-preview/{allocationId}', [MemberRoomController::class, 'handlePaymentPreview'])->name('rooms.confirm.payment.preview');

Route::post('/room/payment-store/{allocationId}', [MemberRoomController::class, 'storePayment'])
    ->name('rooms.payment.pay');

// Route::post('/process-room-save/{allocationId}', [MemberRoomController::class, 'handlePaymentStore'])->name('custom.payment.store');

Route::post('/room/payment-store/{allocationId}', [MemberRoomController::class, 'handlePaymentStore'])->name('custom.payment.store');

Route::get('/payment-success', [MemberRoomController::class, 'paymentSuccess'])->name('payment.success');

Route::post('/room/payment-pay/{allocationId}', [MemberRoomController::class, 'handlePaymentStore'])->name('rooms.payment.pay');

Route::get('/payment-cancel', function () {
    return redirect()->route('member.my-room')->with('error', 'Payment was cancelled.');
})->name('checkout-cancel');

// Route::post('/member/pay-pending/{allocationId}', [PendingPaymentController::class, 'handlePendingPaymentStore'])->name('pending.payment.store');
// Route::get('/member/pending-payment-success', [PendingPaymentController::class, 'pendingPaymentSuccess'])->name('pending.payment.success');

// Pending Payment Routes
Route::post('/member/pay-pending/{allocationId}', [PendingPaymentController::class, 'handlePendingPaymentStore'])->name('pending.payment.store');
Route::get('/member/pending-payment-success', [PendingPaymentController::class, 'pendingPaymentSuccess'])->name('pending.payment.success');
Route::get('/payment-cancel', function () {
    return redirect()->route('member.payments.index')->with('error', 'Payment was cancelled.');
})->name('member.payments');

