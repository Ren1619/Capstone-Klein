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
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landing page/landing_page');
});


Route::get('/login', function () {
    return view('login');
});


Route::get('/dashboard', function () {
    return view('dashboard/dashboard');
});

Route::get('/patientsRecord', function () {
    return view('patients record/patient_record');
});

Route::get('/services', function () {
    return view('services/services');
});

Route::get('/logs', function () {
    return view('logs/logs');
});

Route::get('/pos', function () {
    return view('pos/pos');
});

Route::get('/inventory', function () {
    return view('inventory/inventory');
});

Route::get('/staffs', function () {
    return view('staffs/staffs');
});

Route::get('/reports', function () {
    return view('reports/reports');
});


Route::get('/patientsDetails', function () {
    return view('patients record/patient_detail');
});


Route::get('/patientsVisits', function () {
    return view('patients record/patient_visit');
});

//BRANCHES ROUTES
Route::get('/branches', [BranchController::class, 'index'])->name('branches.index');
Route::post('/branches', [BranchController::class, 'store'])->name('branches.store');
Route::get('/branches/{id}', [BranchController::class, 'show'])->name('branches.show');
Route::put('/branches/{id}', [BranchController::class, 'update'])->name('branches.update');
Route::delete('/branches/{id}', [BranchController::class, 'destroy'])->name('branches.destroy');

//INVENTORY ROUTES
Route::get('/inventory', [ProductController::class, 'index'])->name('inventory.index');
Route::post('/inventory', [ProductController::class, 'store'])->name('inventory.store');
Route::get('/inventory/{id}', [ProductController::class, 'show'])->name('inventory.show');
Route::put('/inventory/{id}', [ProductController::class, 'update'])->name('inventory.update');
Route::delete('/inventory/{id}', [ProductController::class, 'destroy'])->name('inventory.destroy');

//SERVICES ROUTES
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');
Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');
Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');



// Appointment Routes
// Appointment routes
Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/appointments/filter', [AppointmentController::class, 'filter'])->name('appointments.filter');
Route::get('/appointments/counts', [AppointmentController::class, 'counts'])->name('appointments.counts');
Route::put('/appointments/{id}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status.update');
// Feedback Routes
Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
Route::post('/feedbacks', [FeedbackController::class, 'store'])->name('feedbacks.store');

Route::resource('categories', CategoryController::class);

Route::get('/api/categories/type/product', [CategoryController::class, 'getProductCategories']);
Route::get('/api/categories/type/service', [CategoryController::class, 'getServiceCategories']);


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

