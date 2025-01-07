<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/approve-post/{id}', [AdminController::class, 'approvePost'])->name('admin.approve_post');
    Route::get('/admin/student-request', [AdminController::class, 'show_students'])->name('admin.student');
    Route::get('/admin/students/{id}/details', [AdminController::class, 'getStudentDetails'])->name('admin.student.details');
    Route::get('/admin/approve-student/{id}', [AdminController::class, 'approveStudent'])->name('admin.approve_student');
    Route::delete('/student/delete/{id}', [AdminController::class, 'studentDestroy'])->name('students.destroy');

    // Agency routes
Route::get('/admin/agency-requests', [AdminController::class, 'showAgencyRequests'])->name('admin.agency');
Route::get('/admin/approve-agency/{id}', [AdminController::class, 'approveAgency'])->name('admin.approve_agency');
Route::delete('/admin/delete-agency/{id}', [AdminController::class, 'destroyAgency'])->name('admin.delete_agency');
Route::get('/admin/agency-details/{id}', [AdminController::class, 'getAgencyDetails'])->name('admin.agency.details');



// Visa Pack routes
Route::get('/admin/visa-offer-details/{id}', [AdminController::class, 'getVisaOfferDetails'])->name('admin.visa_offer.details');
Route::get('/admin/all-visa-offers', [AdminController::class, 'showVisaPack'])->name('admin.visa_offers');
Route::get('/admin/approve-visa-offer/{id}', [AdminController::class, 'approveVisaOffer'])->name('admin.approve_visa_offer');
Route::delete('/admin/delete-visa-offer/{id}', [AdminController::class, 'destroyVisaOffer'])->name('admin.delete_visa_offer');



});

Route::middleware(['auth', 'role:agency'])->group(function () {
    Route::get('/agency', [AgencyController::class, 'index'])->name('agency.dashboard');
    Route::put('/agency/{id}', [AgencyController::class, 'update'])->name('agency.update');
    Route::post('/agency/offers', [AgencyController::class, 'addOffer'])->name('agency.addOffer');
    Route::delete('/agency/deleteOffer/{id}', [AgencyController::class, 'deleteOffer'])->name('agency.deleteOffer');
    Route::get('/agency/offers/{id}', [AgencyController::class, 'fetchOffer'])->name('agency.fetchOffer');



// Edit Offer (GET request to fetch details)
Route::get('/agency/offers/{id}/edit', [AgencyController::class, 'editOffer'])->name('agency.editOffer');

// Update Offer (PUT request)
Route::put('/agency/offers/{id}', [AgencyController::class, 'updateOffer'])->name('agency.updateOffer');





});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student', [StudentController::class, 'index'])->name('student.dashboard');
    Route::put('/student/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::get('/student/check-eligibility-for-study-abroad', [StudentController::class, 'showEligibility'])->name('student.eligibility');
    Route::post('/student/check-eligibility', [StudentController::class, 'assessEligibility'])->name('student.checkEligibility');

});


// Grouping routes under HomeController
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home.index'); // Homepage
    Route::get('/all-blogs', 'show_blogs')->name('home.blog'); // blog Page
    Route::get('/blog/search', 'searchBlog')->name('home.blog.search'); // Live search endpoint
    Route::get('/blog/{id}', 'blogShow')->name('home.blog.show'); // Single blog post
    Route::get('/services', 'services')->name('home.services'); // Services Page
    Route::get('/packages', 'packages')->name('home.packages'); // Study Abroad Packages
    Route::get('/packages/{id}', 'packageDetails')->name('home.package.details'); // Package Details
    Route::get('/contact', 'contact')->name('home.contact'); // Contact Page
});



Route::middleware(['auth'])->group(function () {
    // List all blogs for the user
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');

    // Admin view to manage all blogs
    Route::get('/blogs/admin', [BlogController::class, 'admin_show'])->name('blogs.admin_show');

    // Create a new blog
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');

    // Edit a blog
    Route::get('/blogs/{post}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{post}', [BlogController::class, 'update'])->name('blogs.update');

    // Delete a blog
    Route::delete('/blogs/{post}', [BlogController::class, 'destroy'])->name('blogs.destroy');
});


Route::get('/clogin', [LoginController::class, 'showLoginForm'])->name('clogin');
Route::post('/clogin', [LoginController::class, 'login']);
Route::post('/clogout', [LoginController::class, 'logout'])->name('clogout');
Route::post('/signup', [LoginController::class, 'signup'])->name('signup');
Route::get('/signup', [LoginController::class, 'showSignup'])->name('signup.show');






require __DIR__.'/auth.php';
