<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job:slug}', [JobController::class, 'show'])->name('jobs.show');
Route::post('/jobs/{job}/apply', [\App\Http\Controllers\JobApplicationController::class, 'store'])->name('jobs.apply')->middleware('auth');

Route::get('/internships', [InternshipController::class, 'index'])->name('internships.index');
Route::get('/internships/{slug}', [InternshipController::class, 'show'])->name('internships.show');
Route::post('/internships/{slug}/apply', [\App\Http\Controllers\InternshipApplicationController::class, 'store'])->name('internships.apply')->middleware('auth');
Route::get('/internships/{slug}/applied', [\App\Http\Controllers\InternshipApplicationController::class, 'check'])->name('internships.applied')->middleware('auth');

Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
Route::get('/companies/{company:slug}', [CompanyController::class, 'show'])->name('companies.show');
Route::post('/companies/{company}/follow', [\App\Http\Controllers\CompanyFollowController::class, 'toggle'])
    ->name('companies.follow')
    ->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Candidate Specific Dashboards
    Route::get('/my-profile', [App\Http\Controllers\CandidateController::class, 'profile'])->name('candidate.profile');
    Route::post('/my-profile', [App\Http\Controllers\CandidateController::class, 'updateProfile'])->name('candidate.profile.update');
    Route::get('/my-applications', [App\Http\Controllers\CandidateController::class, 'applications'])->name('candidate.applications');
    // Notifications
    Route::get('/api/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/api/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/api/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // Shared (Admin + Company)
    Route::middleware('role:admin,company')->group(function () {
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Jobs
        Route::resource('jobs', Admin\JobController::class);
        Route::post('jobs/{job}/approve', [Admin\JobController::class, 'approve'])->name('jobs.approve');
        Route::post('jobs/{job}/reject', [Admin\JobController::class, 'reject'])->name('jobs.reject');
        Route::get('jobs/{job}/applicants', [Admin\JobController::class, 'applicants'])->name('jobs.applicants');
    });

    // Shared (Admin & Company): Applications
    Route::middleware('role:admin,company')->group(function () {
        // Applications
        Route::resource('applications', Admin\ApplicationController::class);
        Route::post('applications/{application}/approve', [Admin\ApplicationController::class, 'approve'])->name('applications.approve');
        Route::post('applications/{application}/shortlist', [Admin\ApplicationController::class, 'shortlist'])->name('applications.shortlist');
        Route::post('applications/{application}/hire', [Admin\ApplicationController::class, 'hire'])->name('applications.hire');
        Route::post('applications/{application}/reject', [Admin\ApplicationController::class, 'reject'])->name('applications.reject');
        Route::post('applications/{application}/status', [Admin\ApplicationController::class, 'updateStatus'])->name('applications.status');
    });

    // Admin Only
    Route::middleware('role:admin')->group(function () {
        // Users
        Route::resource('users', Admin\UserController::class);
        
        // Companies
        Route::resource('companies', Admin\CompanyController::class);
        
        // Internships
        Route::resource('internships', Admin\InternshipController::class);
        Route::post('internships/{internship}/approve', [Admin\InternshipController::class, 'approve'])->name('internships.approve');
        Route::post('internships/{internship}/reject', [Admin\InternshipController::class, 'reject'])->name('internships.reject');
        
        // Skills
        Route::resource('skills', Admin\SkillController::class);
        
        // Settings & Pages
        Route::get('settings', [Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [Admin\SettingController::class, 'update'])->name('settings.update');
        Route::resource('about_sections', Admin\AboutSectionController::class)->except(['create', 'store', 'show', 'destroy']);
        
        // Reports & Analytics
        Route::get('reports', [Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export', [Admin\ReportController::class, 'export'])->name('reports.export');
    });
});

require __DIR__ . '/auth.php';
