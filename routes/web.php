<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\EstateController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Api\CustomerController as CustomerApiController;

Route::get('/', function () {
    return Inertia::render('Homepage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});



Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

Route::middleware(['auth', 'verified'])->name('admin.')->prefix('admin')->group(function(){
    Route::resource('/estates', EstateController::class);
    Route::resource('/customers', CustomerController::class);
    Route::resource('/areas', AreaController::class);
    Route::post('/api/customers/store', [CustomerApiController::class, 'store'])->name('api.customers.store');
});

require __DIR__.'/auth.php';
