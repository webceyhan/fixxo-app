<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome/Index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    /**
     * Dashboard
     */
    Route::get('/dashboard', DashboardController::class)->middleware('verified')->name('dashboard');

    /**
     * Profile
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /**
     * Ticket extras
     */
    Route::post('/uploads', [UploadController::class, 'store'])->name('uploads.store');
    Route::delete('/uploads', [UploadController::class, 'destroy'])->name('uploads.destroy');
    Route::post('/tickets/{ticket}/sign', [TicketController::class, 'sign'])->name('tickets.sign');

    /**
     * Resources
     */
    Route::resource('users', UserController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('devices', DeviceController::class);
    Route::resource('tickets', TicketController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('tasks', TaskController::class)->only(['store', 'update', 'destroy']);
    Route::resource('transactions', TransactionController::class)->only(['store', 'update', 'destroy']);
});

require __DIR__ . '/auth.php';
