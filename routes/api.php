<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\AccountRoleController;
use App\Http\Controllers\BranchController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Account routes
Route::get('accounts/role/{roleId}', [AccountController::class, 'getByRole']);
Route::get('accounts/branch/{branchId}', [AccountController::class, 'getByBranch']);
Route::apiResource('accounts', AccountController::class);

// Account Role routes
Route::apiResource('roles', AccountRoleController::class);
Route::get('roles/{id}/accounts', [AccountRoleController::class, 'getAccounts']);

Route::get('branches', [BranchController::class, 'apiIndex']);

Route::get('branches/dropdown', [BranchController::class, 'getBranchesForDropdown'])->name('branches.dropdown');

// Log routes   
Route::get('logs', [LogController::class, 'index']);
Route::post('logs', [LogController::class, 'store']);
Route::get('logs/{id}', [LogController::class, 'show']);
Route::delete('logs/{id}', [LogController::class, 'destroy']);
Route::get('logs/account/{accountId}', [LogController::class, 'getByAccount']);
Route::get('logs/action/{action}', [LogController::class, 'getByAction']);
Route::post('logs/date-range', [LogController::class, 'getByDateRange']);
Route::get('logs/summary', [LogController::class, 'getSummary']);

// Sales Routes
Route::prefix('sales')->group(function () {
    // Test endpoint
    Route::get('/test', [SalesController::class, 'test']);

    // POS specific routes - PUT THESE FIRST
    Route::get('/daily', [SalesController::class, 'getDailySales']);
    Route::get('/export', [SalesController::class, 'export']);

    // Reports and analytics routes
    Route::prefix('reports')->group(function () {
        Route::get('/overview', [SalesController::class, 'getOverview']);
        Route::get('/chart-data', [SalesController::class, 'getChartData']);
        Route::get('/branch-comparison', [SalesController::class, 'getBranchComparison']);
    });

    // Basic CRUD operations - PUT PARAMETERIZED ROUTES LAST
    Route::get('/', [SalesController::class, 'index']);
    Route::post('/', [SalesController::class, 'store']);
    Route::get('/{sale}', [SalesController::class, 'show']); // This should be LAST
});

Route::get('/feedbacks/{id}', [App\Http\Controllers\FeedbackController::class, 'getFeedback']);