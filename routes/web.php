<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\POSController;

use App\Http\Controllers\Patients\PatientController;
use App\Http\Controllers\Patients\VisitController;
use App\Http\Controllers\Patients\AllergyController;
use App\Http\Controllers\Patients\MedicalConditionController;
use App\Http\Controllers\Patients\MedicationController;
use App\Http\Controllers\Patients\VisitServiceController;
use App\Http\Controllers\Patients\VisitProductController;
use App\Http\Controllers\Patients\DiagnosisController;
use App\Http\Controllers\Patients\PrescriptionController;

use App\Http\Controllers\SalesController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AccountRoleController;
use App\Models\AccountRole;
use App\Models\Account;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Models\Sale;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Include Laravel Breeze Authentication Routes
require __DIR__ . '/auth.php';

Route::get('/api/sales/test', [SalesController::class, 'test']);
Route::get('/api/sales/daily', [SalesController::class, 'getDailySales']);
Route::get('/api/sales/reports/overview', [SalesController::class, 'getOverview']);
Route::get('/api/sales/reports/chart-data', [SalesController::class, 'getChartData']);
Route::get('/api/sales/reports/branch-comparison', [SalesController::class, 'getBranchComparison']);
Route::get('/api/sales', [SalesController::class, 'index']);
Route::post('/api/sales', [SalesController::class, 'store']);

Route::get('/', function () {
    return view('landing page/landing_page');
});

// Override Breeze login routes with our custom implementation
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

// Protected routes that require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard/dashboard');
    })->name('dashboard');

    Route::get('/patientsRecord', function () {
        return view('patients record/patient_record');
    });

    Route::get('/services', function () {
        return view('services/services');
    });

    Route::get('/inventory', function () {
        return view('inventory/inventory');
    });

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/staffs', function () {
            return view('staffs/staffs');
        });


        Route::get('/branches', [BranchController::class, 'index'])->name('branches.index');
        Route::post('/branches', [BranchController::class, 'store'])->name('branches.store');
        Route::get('/branches/{id}', [BranchController::class, 'show'])->name('branches.show');
        Route::put('/branches/{id}', [BranchController::class, 'update'])->name('branches.update');
        Route::delete('/branches/{id}', [BranchController::class, 'destroy'])->name('branches.destroy');

        // Account management routes
        Route::get('/roles', [AccountRoleController::class, 'index'])->name('roles.index');

        // Log routes
        Route::get('/logs', [App\Http\Controllers\LogController::class, 'index'])->name('logs.index');

        Route::get('/reports', function () {
            return view('reports/reports');
        });
    });



    Route::get('/patientsDetails', function () {
        return view('patients record/patient_detail');
    });

    Route::get('/patientsVisits', function () {
        return view('patients record/patient_visit');
    });

    Route::get('/dashboard/profile.edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Password update route
    Route::put('update-password', [PasswordController::class, 'update'])->name('password.update');

    // Email verification routes (if you're using email verification)
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    //INVENTORY ROUTES
    Route::get('/inventory', [ProductController::class, 'index'])->name('inventory.index');
    Route::post('/inventory', [ProductController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{id}', [ProductController::class, 'show'])->name('inventory.show');
    Route::put('/inventory/{id}', [ProductController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [ProductController::class, 'destroy'])->name('inventory.destroy');

    Route::resource('services', ServiceController::class);

    // Appointment Routes
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/filter', [AppointmentController::class, 'filter'])->name('appointments.filter');
    Route::get('/appointments/counts', [AppointmentController::class, 'counts'])->name('appointments.counts');
    Route::put('/appointments/{id}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status.update');


    // Feedback Routes


    Route::resource('categories', CategoryController::class);

    // POS routes
    Route::get('/pos', [POSController::class, 'index']);

    // NON-API Sales routes (for direct web access)
    Route::get('/sales/daily', [SalesController::class, 'getDailySales']);
    Route::post('/sales', [SalesController::class, 'store']);


});

Route::middleware('guest')->group(function () {
    Route::get('/two-factor', [App\Http\Controllers\Auth\TwoFactorController::class, 'show'])
        ->name('two-factor.show');
    Route::post('/two-factor', [App\Http\Controllers\Auth\TwoFactorController::class, 'verify'])
        ->name('two-factor.verify');
    Route::post('/two-factor/resend', [App\Http\Controllers\Auth\TwoFactorController::class, 'sendCode'])
        ->name('two-factor.send');
});




// Feedback Routes
Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
Route::post('/feedbacks', [FeedbackController::class, 'store'])->name('feedbacks.store');

Route::resource('categories', CategoryController::class);

Route::get('/api/categories/type/product', [CategoryController::class, 'getProductCategories']);
Route::get('/api/categories/type/service', [CategoryController::class, 'getServiceCategories']);

// POS routes
Route::get('/pos', [POSController::class, 'index']);

// NON-API Sales routes (for direct web access)
Route::get('/sales/daily', [SalesController::class, 'getDailySales']);
Route::post('/sales', [SalesController::class, 'store']);


Route::get('/pos', [POSController::class, 'index'])->name('pos.index');





// Patients resource routes
Route::resource('patients', PatientController::class);

// Custom route for patient details page that was in the original code
Route::get('/patientsDetails/{id?}', [PatientController::class, 'show'])->name('patients.details');


// Visit routes
Route::resource('visits', VisitController::class)->except(['create', 'edit']);

// Patient-specific visit routes that don't fit the resource pattern
Route::post('/patients/{id}/visits', [VisitController::class, 'store'])->name('visits.store');
Route::get('/patients/{id}/visits', [VisitController::class, 'getPatientVisits'])->name('patients.visits');

// Medical conditions 
Route::resource('conditions', MedicalConditionController::class);

// Patient-specific medical condition route that doesn't fit the resource pattern
Route::post('/patients/{patient}/conditions', [MedicalConditionController::class, 'store'])->name('conditions.store');

// Allergy routes 
Route::resource('allergies', AllergyController::class);

// Patient-specific allergy route that doesn't fit the resource pattern
Route::post('/patients/{patient}/allergies', [AllergyController::class, 'store'])->name('allergies.store');



// Medication routes 
Route::resource('medications', MedicationController::class);

// Patient-specific medication route that doesn't fit the resource pattern
Route::post('/patients/{patient}/medications', [MedicationController::class, 'store'])->name('medications.store');



// Redirects from old URLs to new ones for backward compatibility 
Route::get('/patientsRecord', function () {
    return redirect()->route('patients.index');
});


// Prescription routes
Route::resource('prescriptions', PrescriptionController::class);

// Visit services routes
Route::resource('visit-services', VisitServiceController::class);

// Visit product routes
Route::resource('visit-products', VisitProductController::class);

// Diagnosis routes
Route::resource('diagnosis', DiagnosisController::class);


Route::middleware(['web'])->group(function () {
    Route::post('/api/submit-feedback', [FeedbackController::class, 'submitFeedback']);
    Route::post('/api/validate-appointment-code', [FeedbackController::class, 'validateAppointmentCode']);
});
Route::get('/api/appointments/{id}/check-feedback-eligibility', [AppointmentController::class, 'checkFeedbackEligibility']);
Route::get('/api/appointments/completed-without-feedback', [AppointmentController::class, 'getCompletedWithoutFeedback']);

Route::get('/create-dummy-account', function () {

    // Get the first branch
    $branch = DB::table('branches')->first();

    if (!$branch) {
        return "Error: No branches found in the database. Please create a branch first.";
    }

    // Create admin account
    $admin = Account::create([
        'role_ID' => 1,
        'branch_ID' => $branch->branch_ID,
        'last_name' => 'System',
        'first_name' => 'Admin',
        'contact_number' => '09569104353',
        'email' => 'allenklein04@gmail.com',
        'password' => Hash::make('00000000'),
    ]);

    return "Admin account created successfully!<br>
            Email: allenlalay04@gmail.com<br>
            Password: 00000000<br>
            <strong>IMPORTANT: Delete this route and change this password after login!</strong>";
});

Route::get('/auth-user', function () {
    return auth()->user()->account_ID;
});

Route::get('/auth-check', function () {
    return auth()->check() ? 'Authenticated' : 'Not Authenticated';
});
