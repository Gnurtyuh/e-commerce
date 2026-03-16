<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\InventoryController;

Route::get('/', function () {
    return redirect('/admin/dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Auth
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware('admin.auth')->group(function () {

    Route::redirect('/', '/admin/dashboard');

    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */

    Route::resource('categories', CategoryController::class);

    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */

    Route::get('products/{id}/variants', [ProductController::class, 'variants'])
        ->name('products.variants');

    Route::get('products/{id}/images', [ProductController::class, 'images'])
        ->name('products.images');

    Route::post('products/{id}/variants', [\App\Http\Controllers\Admin\VariantController::class, 'store']);
    Route::put('variants/{id}', [\App\Http\Controllers\Admin\VariantController::class, 'update']);
    Route::delete('variants/{id}', [\App\Http\Controllers\Admin\VariantController::class, 'destroy']);

    Route::post('products/{id}/images', [\App\Http\Controllers\Admin\ImageController::class, 'store']);
    Route::patch('images/{id}/main', [\App\Http\Controllers\Admin\ImageController::class, 'setMain']);
    Route::delete('images/{id}', [\App\Http\Controllers\Admin\ImageController::class, 'destroy']);

    Route::resource('products', ProductController::class);

    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */

    Route::resource('users', UserController::class)->only(['index']);

    /*
    |--------------------------------------------------------------------------
    | Orders
    |--------------------------------------------------------------------------
    */

    Route::resource('orders', OrderController::class)->only(['index', 'show']);

/*
|--------------------------------------------------------------------------
| Payments
|--------------------------------------------------------------------------
*/

Route::get('payments', [PaymentController::class, 'index'])
    ->name('admin.payments.index');

Route::get('payments/order/{orderId}', [PaymentController::class, 'byOrder'])
    ->name('admin.payments.byOrder');

Route::post('payments/create/{orderId}', [PaymentController::class, 'create'])
    ->name('admin.payments.create');

Route::get('payments/status/{orderCode}', [PaymentController::class, 'status'])
    ->name('admin.payments.status');

Route::get('inventory', [InventoryController::class,'index'])
    ->name('inventory.index');
});
