<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PermissionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class,'login']);

Route::post('/logout', [AuthController::class,'logout'])
->middleware('auth:sanctum');

Route::prefix('/')->group(function () {
    // Route::apiresource('users', UserController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('suppliers', SupplierController::class);
    Route::apiResource('medicines', MedicineController::class);
});

Route::prefix('/medicines')->group(function () {
    Route::post('/purchase', [PurchaseController::class, 'purchase']);
    Route::post('/{medicine}/upload-image', [MedicineController::class, 'uploadImage']);
    Route::get('/', [MedicineController::class, 'search']);
})->middleware('auth');

Route::middleware(['auth'])->group(function () {
    // Permission routes
    Route::apiResource('permissions', PermissionController::class)->except('destroy');
    Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    // Role routes
    Route::apiResource('roles', RoleController::class);
    // Route::get('roles/{role}/add-permissions', RoleController::class, 'addPermissionToRole');
    // Route::put('roles/{role}/give-permissions', RoleController::class, 'givePermissionToRole');
    Route::put('roles/{role}/permissions', [RoleController::class, 'addPermissionsToRole'])->name('roles.permissions.add');
    Route::get('roles/{role}/permissions', [RoleController::class, 'showPermissionsToRole'])->name('roles.permissions.show');

    // User routes
    Route::apiResource('users', UserController::class);
});

Route::group(['middleware' => ['role:admin|encoder|pharmacist|viewer']], function() {

    Route::apiresource('permissions', PermissionController::class)->except('destroy');
    Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);

    Route::apiresource('roles', RoleController::class);
    // Route::delete('roles/{roleId}/delete', [RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);

    Route::apiresource('users', UserController::class)->except('destroy');
    Route::get('users/{userId}/delete', [UserController::class, 'destroy']);
});
