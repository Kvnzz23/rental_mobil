<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RentalsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth', 'prevent-back')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/data-mobil', [CarsController::class, 'index'])
        ->name('cars.index');

    Route::get('/data-customer', [CustomersController::class, 'index'])->name('customer.index');

    Route::get('/data-customer/create', [CustomersController::class, 'create'])->name('customer.create');
    Route::post('/data-customer', [CustomersController::class, 'store'])->name('customer.store');

    Route::get('/data-customer/{id}/edit', [CustomersController::class, 'edit'])
        ->name('customer.edit');

    Route::put('/data-customer/{id}', [CustomersController::class, 'update'])
        ->name('customer.update');

    Route::delete('/data-customer/{id}', [CustomersController::class, 'destroy'])->name('customer.destroy');

    Route::resource('/data-rental', RentalsController::class)->names('rental');
    Route::patch('/data-rental/{id}/selesai', [RentalsController::class, 'selesai'])->name('rental.selesai');

    Route::middleware('role:admin,staff')->group(function () {
        Route::get('/data-payment', [PaymentController::class, 'index'])->name('payment.index');
        Route::patch('/data-payment/{id}/paid', [PaymentController::class, 'paid'])->name('payment.paid');
        Route::get('/data-payment/{id}/nota' , [PaymentController::class, 'nota'])->name('payment.nota');
    });

    Route::middleware('role:admin')->group(function () {

        Route::get('/data-mobil/create', [CarsController::class, 'create'])
            ->name('cars.create');

        Route::post('/data-mobil', [CarsController::class, 'store'])
            ->name('cars.store');

        Route::get('/data-mobil/{id}/edit', [CarsController::class, 'edit'])
            ->name('cars.edit');

        Route::put('/data-mobil/{id}', [CarsController::class, 'update'])
            ->name('cars.update');

        Route::delete('/data-mobil/{id}', [CarsController::class, 'destroy'])->name('cars.destroy');

        Route::resource('/data-user', UserController::class)->names('users');
    });
});
