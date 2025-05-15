<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CategoryController;
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

// API endpoint for getting categories by type
Route::get('api/categories/type/{type}', [CategoryController::class, 'getByType']);