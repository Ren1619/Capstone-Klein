<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\AccountRoleController;

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


//account routes
Route::apiResource('accounts', AccountController::class);
Route::get('accounts/role/{roleId}', [AccountController::class, 'getByRole']);
Route::get('accounts/branch/{branchId}', [AccountController::class, 'getByBranch']);

// Account Role routes
Route::apiResource('roles', AccountRoleController::class);
Route::get('roles/{id}/accounts', [AccountRoleController::class, 'getAccounts']);

// Log routes   
Route::get('logs', [LogController::class, 'index']);
Route::post('logs', [LogController::class, 'store']);
Route::get('logs/{id}', [LogController::class, 'show']);
Route::delete('logs/{id}', [LogController::class, 'destroy']);
Route::get('logs/account/{accountId}', [LogController::class, 'getByAccount']);
Route::get('logs/action/{action}', [LogController::class, 'getByAction']);
Route::post('logs/date-range', [LogController::class, 'getByDateRange']);
Route::get('logs/summary', [LogController::class, 'getSummary']);

// Sales Routes (Read-only)
Route::prefix('sales')->group(function () {
    Route::get('/', [SalesController::class, 'index']);
    Route::get('/{sale}', [SalesController::class, 'show']);
    Route::get('/{sale}/cart-items', [SalesController::class, 'getCartItems']);
    Route::get('/date-range/search', [SalesController::class, 'getByDateRange']);
    Route::get('/reports/summary', [SalesController::class, 'getReport']);
    Route::get('/product-items/search', [SalesController::class, 'searchProductItems']);
    Route::get('/service-items/search', [SalesController::class, 'searchServiceItems']);
});